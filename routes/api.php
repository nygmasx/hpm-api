<?php

use App\Models\AdvancedTracability;
use App\Models\Equipment;
use App\Models\Image;
use App\Models\Product;
use App\Models\Temperature;
use App\Models\Tracability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/{user}/products', function (User $user) {
    return $user->products;
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user->only('id', 'name', 'email'),
    ], 201);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json("Logged out", 200);
});

Route::middleware('auth:sanctum')->post('/simple-tracking', function (Request $request) {
    $request->validate([
        'opened_at' => 'required|date',
        'simple_label_pictures.*' => 'required|image|mimes:jpg,jpeg,png',
    ]);

    // Create the Tracability record
    $tracability = Tracability::create([
        'user_id' => auth()->id(),
        'opened_at' => $request->opened_at,
    ]);

    $imageIds = [];
    if ($request->hasFile('simple_label_pictures')) {
        foreach ($request->file('simple_label_pictures') as $file) {
            $url = $file->store('label_pictures', 'public');

            // Create Image record
            $image = Image::create(['url' => $url]);

            $imageIds[] = $image->id;
        }
    }

    // Attach images to Tracability
    if ($imageIds) {
        $tracability->images()->attach($imageIds);
    }

    return response()->json(['message' => 'Tracability created successfully.']);
});

Route::middleware('auth:sanctum')->post('/product/new', function (Request $request) {

    $request->validate([
        'name' => 'required',
    ]);

    Product::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
    ]);

    return response()->json(['message' => 'Product created successfully.']);

});

Route::middleware('auth:sanctum')->post('/advanced-tracability/new', function (Request $request) {
    // Validate the incoming request data
    $request->validate([
        'opened_at' => 'required|date',
        'service' => 'required|string',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.expiration_date' => 'required|date',
        'products.*.quantity' => 'required|string',
        'products.*.label_pictures.*' => 'required|image|mimes:jpg,jpeg,png',
    ]);

    // Create the Advanced Tracability record
    $advancedTracability = AdvancedTracability::create([
        'user_id' => auth()->id(),
        'opened_at' => $request->opened_at,
        'service' => $request->service,
    ]);

    // Handle products and associated images
    foreach ($request->products as $productData) {
        $product = Product::find($productData['product_id']);

        // Store product image(s) and create Image records
        $imageIds = [];
        if (isset($productData['label_pictures'])) {
            foreach ($productData['label_pictures'] as $file) {
                $url = $file->store('label_pictures', 'public');
                $image = Image::create(['url' => $url]);
                $imageIds[] = $image->id;
            }
        }

        if (!empty($imageIds)) {
            $advancedTracability->images()->attach($imageIds);
        }

        // Attach product and image(s) to the advanced tracability
        $advancedTracability->product()->attach($product->id, [
            'expiration_date' => $productData['expiration_date'],
            'quantity' => $productData['quantity'],
            'label_picture' => $imageIds[0] ?? null, // Assuming one label picture per product, adjust as needed
        ]);
    }

    return response()->json(['message' => 'Advanced Tracability created successfully.']);
});


Route::middleware('auth:sanctum')->post('/equipment/new', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'type' => 'required',
    ]);

    Equipment::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'type' => $request->type,
    ]);

    return response()->json(['message' => 'Equipment created successfully.']);

});

Route::get('user/{user}/equipments', function (User $user) {
    return $user->equipments;
});

Route::middleware('auth:sanctum')->post('/temperature/new', function (Request $request) {

    $request->validate([
        'reading_date' => 'required|date',
        'equipments' => 'required|array',
        'equipments.*.equipment_id' => 'required|exists:equipments,id',
        'equipments.*.degrees' => 'required|string',
    ]);

    $temperature = Temperature::create([
        'user_id' => auth()->id(),
        'reading_date' => $request->reading_date,
    ]);

    foreach ($request->equipments as $equipmentData) {
        $equipment = Equipment::find($equipmentData['equipment_id']);
        $temperature->equipments()->attach($equipment->id, [
            'degree' => $equipmentData['degree'],
        ]);
    }

    return response()->json(['message' => 'Temperature statement created successfully.']);
});
