<?php

use App\Models\AdvancedTracability;
use App\Models\CleaningPlan;
use App\Models\CleaningStation;
use App\Models\CleaningTask;
use App\Models\CleaningZone;
use App\Models\Equipment;
use App\Models\Image;
use App\Models\OilControl;
use App\Models\OilTray;
use App\Models\Product;
use App\Models\Reception;
use App\Models\Supplier;
use App\Models\Temperature;
use App\Models\TemperatureChangement;
use App\Models\Tracability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $advancedTracability->products()->attach($product->id, [
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
        'equipments.*.equipment_id' => 'required|exists:equipment,id',
        'equipments.*.degrees' => 'required|string',
    ]);

    $temperature = Temperature::create([
        'user_id' => auth()->id(),
        'reading_date' => $request->reading_date,
    ]);

    foreach ($request->equipments as $equipmentData) {
        $equipment = Equipment::find($equipmentData['equipment_id']);
        $temperature->equipments()->attach($equipment->id, [
            'degree' => $equipmentData['degrees'],
        ]);
    }

    return response()->json(['message' => 'Temperature statement created successfully.']);
});

Route::get('user/{user}/simple-tracability', function (User $user) {
    $tracabilities = $user->tracabilities()->with('images')->get();
    return response()->json($tracabilities);
});

Route::get('user/{user}/advanced-tracability', function (User $user) {
    return $user->advancedTracabilities()->with(['images', 'products' => function ($query) {
        $query->withPivot('expiration_date', 'quantity', 'label_picture');
    }])->get();
});

Route::get('user/{user}/temperatures', function (User $user) {
    $temperatures = $user->temperatures()->with(['equipments' => function ($query) {
        $query->withPivot('degree');
    }])->get();
    return response()->json($temperatures);
});

Route::get('user/{user}/cleaning-zones', function (User $user) {
    return $user->cleaningZones()
        ->with(['cleaningStations.cleaningTasks' => function($query) use ($user) {
            $query->whereHas('users', function($q) use ($user) {
                $q->where('users.id', $user->id)
                    ->where('users_cleaning_tasks.is_completed', false);
            });
        }])
        ->get()
        ->map(function($zone) {
            return [
                'id' => $zone->id,
                'title' => $zone->name,
                'tasks' => $zone->cleaningStations->flatMap->cleaningTasks->count(),
                'stations' => $zone->cleaningStations
            ];
        });
});

Route::get('cleaning-zone/{zone}/tasks', function (CleaningZone $zone) {
    try {
        // Log the zone ID and related data
        \Log::info('Fetching tasks for zone', [
            'zone_id' => $zone->id,
            'stations_count' => $zone->cleaningStations()->count()
        ]);

        $user = auth()->user();
        \Log::info('User context', ['user_id' => $user ? $user->id : null]);

        $tasks = $zone->cleaningStations()
            ->with(['cleaningTasks' => function($query) use ($user) {
                $query->with(['users' => function($q) use ($user) {
                    $q->where('users.id', $user->id)
                        ->select('users.id', 'users_cleaning_tasks.is_completed');
                }]);
            }])
            ->get()
            ->flatMap(function($station) use ($user) {
                \Log::info('Processing station', [
                    'station_id' => $station->id,
                    'tasks_count' => $station->cleaningTasks->count()
                ]);

                return $station->cleaningTasks->map(function($task) use ($station, $user) {
                    $userTask = $task->users->first();
                    return [
                        'id' => $task->id,
                        'station_id' => $station->id,
                        'station_name' => $station->name,
                        'title' => $task->title,
                        'estimated_time' => $task->estimated_time,
                        'frequency' => $task->frequency,
                        'products' => $task->products,
                        'products_quantity' => $task->products_quantity,
                        'verification_type' => $task->verification_type,
                        'temperature' => $task->temperature,
                        'action_time' => $task->action_time,
                        'utensil' => $task->utensil,
                        'rinse_type' => $task->rinse_type,
                        'drying_type' => $task->drying_type,
                        'is_completed' => $userTask ? $userTask->pivot->is_completed : false
                    ];
                });
            })
            ->values();

        return response()->json($tasks);

    } catch (\Exception $e) {
        \Log::error('Error in cleaning zone tasks route', [
            'zone_id' => $zone->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'Une erreur est survenue lors de la récupération des tâches',
            'details' => $e->getMessage()
        ], 500);
    }
});

Route::get('cleaning-zone/{cleaningZone}/cleaning-station', function (CleaningZone $cleaningZone) {
    return $cleaningZone->cleaningStations;
});

Route::post('/cleaning-station/new', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'cleaning_zone_id' => 'required'
    ]);

    CleaningStation::create([
        'cleaning_zone_id' => $request->cleaning_zone_id,
        'name' => $request->name,
    ]);

    return response()->json(['message' => 'Cleaning Station created successfully.']);
});

Route::put('/cleaning-station/{id}/edit', function (Request $request, $id) {
    // Validate the incoming request data
    $request->validate([
        'name' => 'required',
        'cleaning_zone_id' => 'required'
    ]);

    $cleaningStation = CleaningStation::findOrFail($id);

    $cleaningStation->update([
        'name' => $request->name,
        'cleaning_zone_id' => $request->cleaning_zone_id,
    ]);

    // Return a success message
    return response()->json(['message' => 'Cleaning Station updated successfully.']);
});

Route::delete('/cleaning-station/{cleaningStation}/delete', function (Request $request, CleaningStation $cleaningStation) {
    return response()->json($cleaningStation->delete(), 200);
});

Route::middleware('auth:sanctum')->post('/cleaning-plan/new', function (Request $request) {
    // Validate the request
    $validatedData = $request->validate([
        'date' => 'required|date',
        'cleaning_zones' => 'required|array',
        'cleaning_zones.*.cleaning_zone_id' => 'required|exists:cleaning_zones,id',
        'cleaning_zones.*.cleaning_stations' => 'required|array',
        'cleaning_zones.*.cleaning_stations.*.station_id' => 'required|exists:cleaning_stations,id',
        'cleaning_zones.*.cleaning_stations.*.comment' => 'nullable|string',
        'cleaning_zones.*.cleaning_stations.*.image_url' => 'nullable|image|mimes:jpeg,png,jpg', // Validation pour l'image
    ]);

    // Create the CleaningPlan
    $cleaningPlan = CleaningPlan::create([
        'user_id' => auth()->id(),
        'date' => $request->date,
    ]);

    // Iterate through the cleaning zones and stations
    foreach ($request->cleaning_zones as $zoneData) {
        $zoneId = $zoneData['cleaning_zone_id'];

        foreach ($zoneData['cleaning_stations'] as $stationData) {
            $imageUrl = null;

            // Traitement de l'image si elle existe
            if (isset($stationData['image']) && $stationData['image']->isValid()) {
                $image = $stationData['image'];

                // Générer un nom unique pour l'image
                $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                // Définir le chemin de stockage
                $path = 'cleaning-plans/' . $cleaningPlan->id . '/stations';

                // Stocker l'image
                $imagePath = $image->storeAs($path, $fileName, 'public');

                // Générer l'URL publique
                $imageUrl = Storage::url($imagePath);
            }

            // Attacher la station avec les données
            $cleaningPlan->zones()->attach($zoneId, [
                'cleaning_station_id' => $stationData['station_id'],
                'comment' => $stationData['comment'] ?? null,
                'image_url' => $imageUrl,
            ]);
        }
    }

    return response()->json([
        'message' => 'Cleaning plan created successfully aaaa.',
        'cleaning_plan' => $cleaningPlan->load('zones')
    ]);
});

Route::get('user/{user}/cleaning-tasks', function (User $user) {
    return response()->json([
        'tasks' => $user->cleaningTasks()
            ->withPivot('is_completed')
            ->get()
    ]);
});

Route::get('cleaning-zone/{cleaningZone}/user/{user}/cleaning-tasks', function (CleaningZone $cleaningZone, User $user) {
    $tasks = CleaningTask::query()
        ->whereIn('cleaning_station_id', $cleaningZone->cleaningStations->pluck('id'))
        ->whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->with(['cleaningStation', 'users' => function ($query) use ($user) {
            $query->where('users.id', $user->id);
        }])
        ->get();

    return response()->json(['tasks' => $tasks]);
});

Route::get('user/{user}/cleaning-plans', function (User $user) {
    return $user->cleaningPlans()->with(['zones' => function ($query) {
        $query->withPivot('comment', 'image_url');
    }])->get();
});

Route::get('user/{user}/oil-trays', function (User $user) {
    return $user->oiltrays;
});

Route::middleware('auth:sanctum')->post('/oil-tray/new', function (Request $request) {
    $request->validate([
        'name' => 'required',
    ]);

    OilTray::create([
        'user_id' => auth()->id(),
        'name' => $request->name
    ]);

    return response()->json(['message' => 'Oil tray created successfully.']);
});

Route::middleware('auth:sanctum')->post('/oil-control/new', function (Request $request) {
    $request->validate([
        'date' => 'required|date',
        'oil_trays' => 'required|array',
        'oil_trays.*.oil_tray_id' => 'required|exists:oil_trays,id',
        'oil_trays.*.control_type' => 'required|string',
        'oil_trays.*.temperature' => 'required|numeric',
        'oil_trays.*.polarity' => 'required|numeric',
        'oil_trays.*.corrective_action' => 'required|string',
        'oil_trays.*.image' => 'required|image|mimes:jpg,jpeg,png'
    ]);

    $oilControl = OilControl::create([
        'user_id' => auth()->id(),
        'date' => $request->date
    ]);

    foreach ($request->oil_trays as $index => $oilTrayData) {
        $oilTray = Equipment::findOrFail($oilTrayData['oil_tray_id']);

        $imageUrl = null;
        if ($request->hasFile("oil_trays.{$index}.image")) {
            $file = $request->file("oil_trays.{$index}.image");
            $url = $file->store('oil_trays_pictures', 'public');
            $imageUrl = $url;
        }

        $oilControl->oilTrays()->attach($oilTray->id, [
            'control_type' => $oilTrayData['control_type'],
            'temperature' => $oilTrayData['temperature'],
            'polarity' => $oilTrayData['polarity'],
            'corrective_action' => $oilTrayData['corrective_action'],
            'image_url' => $imageUrl,
        ]);
    }

    return response()->json([
        'message' => 'Oil control data submitted successfully',
        'oil_control_id' => $oilControl->id
    ], 201);
});

Route::get('user/{user}/oil-controls', function (User $user) {
    $oilControls = $user->oilControls()->with(['oilTrays' => function ($query) {
        $query->withPivot('control_type', 'temperature', 'polarity', 'corrective_action', 'image_url');
    }])->get();

    return response()->json($oilControls);
});

Route::middleware('auth:sanctum')->post('/reception/new', function (Request $request) {
    $request->validate([
        'reference' => 'required|string',
        'date' => 'required|date',
        'supplier_id' => 'required|exists:suppliers,id',
        'service' => 'required|string',
        'additional_informations' => 'nullable|string',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'non_compliance_reason' => 'nullable|string',
        'non_compliance_picture' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    try {
        $reception = Reception::create([
            'user_id' => auth()->id(),
            'reference' => $request->reference,
            'date' => $request->date,
            'supplier_id' => $request->supplier_id,
            'service' => $request->service,
            'additional_information' => $request->additional_informations,
            'non_compliance_reason' => $request->non_compliance_reason
        ]);

        if ($request->hasFile('non_compliance_picture')) {
            $path = $request->file('non_compliance_picture')->store('non_compliance_pictures', 'public');
            $reception->non_compliance_picture = $path;
            $reception->save();
        }

        // Handle products
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['product_id']);

            $reception->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
            ]);

            $product->save();
        }

        return response()->json([
            'message' => 'Reception created successfully',
            'reception' => $reception->load('products', 'supplier'),
        ], 201);

    } catch (\Exception $e) {
        if (isset($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json([
            'message' => 'An error occurred while creating the reception',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('user/{user}/suppliers', function (User $user) {
    return $user->suppliers;
});

Route::middleware('auth:sanctum')->post('/supplier/new', function (Request $request) {

    $request->validate([
        'name' => 'required',
    ]);

    Supplier::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
    ]);

    return response()->json(['message' => 'Supplier created successfully.']);

});

Route::get('user/{user}/receptions', function (User $user) {
    $receptions = $user->receptions()->with(['products' => function ($query) {
        $query->withPivot('quantity');
    }])->get();

    return response()->json($receptions);
});

Route::get('user/{user}/files', function (User $user) {
    return $user->files;
});


Route::middleware('auth:sanctum')->post('/tcp/new', function (Request $request) {
    $request->validate([
        'operation_type' => 'required|string',
        'additional_informations' => 'nullable|string',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'start_date' => 'required|date',
        'start_temperature' => 'required|string',
        'end_date' => 'nullable|date',
        'end_temperature' => 'nullable|string',
        'is_finished' => 'required|in:0,1',  // Changed to accept string '0' or '1'
        'corrective_action' => 'nullable|string',
    ]);

    try {
        $temperatureChangement = TemperatureChangement::create([
            'user_id' => auth()->id(),
            'operation_type' => $request->operation_type,
            'additional_informations' => $request->additional_informations,
            'start_date' => $request->start_date,
            'start_temperature' => $request->start_temperature,
            'end_date' => $request->end_date,
            'end_temperature' => $request->end_temperature,
            'is_finished' => $request->is_finished === '1',  // Convert to boolean
            'corrective_action' => $request->corrective_action,
        ]);

        // Handle products
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['product_id']);
            $temperatureChangement->products()->attach($product->id);
            $product->save();
        }

        return response()->json([
            'message' => 'Tcp created successfully',
            'reception' => $temperatureChangement->load('products'),
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while creating the Temperature Changement',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('user/{user}/temperature-changement', function (User $user) {
    $temperatureChangements = $user->temperatureChangements()->with('products')->where('is_finished', false)->get();

    return response()->json($temperatureChangements);
});

Route::get('user/{user}/temperature-changements', function (User $user) {
    $temperatureChangements = $user->temperatureChangements()->with('products')->get();

    return response()->json($temperatureChangements);
});

Route::put('/temperatures-changement/{id}/edit', function (Request $request, $id) {
    // Validate the incoming request data
    $request->validate([
        'start_date' => 'required|date',
        'start_temperature' => 'required|string',
        'end_date' => 'nullable|date',
        'end_temperature' => 'nullable|string',
        'is_finished' => 'required|boolean',
        'corrective_action' => 'nullable|string',
        'operation_type' => 'required|string',
        'additional_informations' => 'nullable|string',
    ]);

    $temperatureChangement = TemperatureChangement::findOrFail($id);

    $updateData = [
        'start_date' => $request->start_date,
        'start_temperature' => $request->start_temperature,
        'operation_type' => $request->operation_type,
        'additional_informations' => $request->additional_informations,
        'is_finished' => $request->is_finished,
    ];

    if ($request->is_finished) {
        $updateData['end_date'] = $request->end_date;
        $updateData['end_temperature'] = $request->end_temperature;
        $updateData['corrective_action'] = null; // Clear corrective action when finished
    } else {
        $updateData['end_date'] = null;
        $updateData['end_temperature'] = null;
        $updateData['corrective_action'] = $request->corrective_action;
    }

    $temperatureChangement->update($updateData);

    // Return a success message with the updated temperature changement
    return response()->json([
        'message' => 'Temperature changement updated successfully.',
        'temperature_changement' => $temperatureChangement
    ]);
});

Route::get('/tcp/{tcp}', function (TemperatureChangement $tcp) {
    return $tcp->load('products');
});
