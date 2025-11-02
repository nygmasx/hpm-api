<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterCustomerController;
use App\Http\Controllers\Subscribe\CreateController;
use App\Http\Controllers\Subscribe\StoreController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('/admin');
});

Route::view('profile', 'profile')
    ->middleware(['auth', 'admin'])
    ->name('profile');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::domain('customer.'.config('app.url'))->group(function () {
    Route::middleware(['auth', 'verified'])
        ->group(function () {
            Route::view('profile', 'subscribe.profile')->name('subscribe.profile');
            Route::prefix('subscribe')
                ->as('subscribe.')
                ->middleware('redirect.subscribed')
                ->group(function () {
                    Route::view('/', 'subscribe.index')->name('index');
                    Route::get('create', CreateController::class)->name('create');
                    Route::post('store', StoreController::class)->name('store');
                });
        });
});

require __DIR__ . '/auth.php';
