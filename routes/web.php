<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\UserIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'admin')
    ->middleware(['auth', 'admin', 'verified'])
    ->name('admin.index');

Route::get('/users', UserIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('users.index');

Route::get('/files', \App\Livewire\FilesIndex::class)
    ->middleware(['auth', 'admin'])
    ->name('files.index');

Route::get('/files/new', \App\Livewire\FilesCreate::class)
    ->middleware(['auth', 'admin'])
    ->name('files.create');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__ . '/auth.php';
