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

Route::get('/cleaning-stations', \App\Livewire\CleaningStationsIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('cleaning-stations.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

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
