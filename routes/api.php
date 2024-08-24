<?php

use App\Models\Product;
use App\Models\Tracability;
use App\Models\User;
use Faker\Provider\Image;
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
