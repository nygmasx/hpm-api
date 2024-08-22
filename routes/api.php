<?php

use App\Models\Product;
use App\Models\Tracability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', function () {
    return Product::with('user:id,name,email')->latest()->get();
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
    request()->validate([
        'opened_at' => 'required',
        'simple_label_pictures.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $tracability = Tracability::create([
        'user_id' => auth()->id(),
        'opened_at' => $request->opened_at,
    ]);

    if ($request->hasFile('simple_label_pictures')) {
        $imageIds = [];
        foreach ($request->file('simple_label_pictures') as $file) {
            $path = $file->store('label_pictures', 'public');

            // Create Image record
            $image = \App\Models\Image::create([
                'path' => $path,
            ]);

            $imageIds[] = $image->id;
        }

        // Attach images to tracability using the pivot table
        $tracability->images()->attach($imageIds);
    }

    return response()->json(['message' => 'Tracability created successfully.']);

});

