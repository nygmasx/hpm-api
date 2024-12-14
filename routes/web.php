<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Subscribe\CreateController;
use App\Http\Controllers\Subscribe\StoreController;
use App\Livewire\UserIndex;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', \App\Livewire\Admin::class)
    ->middleware(['auth', 'admin', 'verified'])
    ->name('admin');

Route::get('/users', UserIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('users.index');

Route::get('/files', \App\Livewire\FilesIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('files.index');

Route::get('/files/new', \App\Livewire\FilesCreate::class)
    ->middleware(['auth', 'admin'])
    ->name('files.create');

Route::get('/cleaning-plans', \App\Livewire\CleaningPlanIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('cleaning-plans.index');

Route::get('/cleaning-task/new', \App\Livewire\CleaningTaskCreate::class)
    ->middleware(['auth', 'admin'])
    ->name('cleaning-tasks.create');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('user/{user}/zones-diagnostic', function (\App\Models\User $user) {
    // Get the zones assigned to user through pivot table
    $userZones = \DB::table('users_cleaning_zones')
        ->join('cleaning_zones', 'users_cleaning_zones.cleaning_zone_id', '=', 'cleaning_zones.id')
        ->where('user_id', $user->id)
        ->select('cleaning_zones.*')
        ->get();

    // Get all stations for these zones
    $zoneIds = $userZones->pluck('id')->toArray();
    $stations = \DB::table('cleaning_stations')
        ->whereIn('cleaning_zone_id', $zoneIds)
        ->get();

    // Get tasks count
    $tasksCount = \DB::table('cleaning_tasks')
        ->join('users_cleaning_tasks', 'cleaning_tasks.id', '=', 'users_cleaning_tasks.cleaning_task_id')
        ->join('cleaning_stations', 'cleaning_tasks.cleaning_station_id', '=', 'cleaning_stations.id')
        ->where('users_cleaning_tasks.user_id', $user->id)
        ->where('users_cleaning_tasks.is_completed', false)
        ->whereIn('cleaning_stations.cleaning_zone_id', $zoneIds)
        ->count();

    return [
        'user_id' => $user->id,
        'assigned_zones' => $userZones,
        'stations_for_zones' => $stations,
        'incomplete_tasks_count' => $tasksCount,
        'zone_ids' => $zoneIds
    ];
});

Route::middleware(['auth', 'verified'])
    ->group(function () {

        Route::prefix('subscribe')
            ->as('subscribe.')
            ->group(function () {
                Route::get('create', CreateController::class)->name('create');
                Route::post('store', StoreController::class)->name('store');
            });

    });

require __DIR__ . '/auth.php';
