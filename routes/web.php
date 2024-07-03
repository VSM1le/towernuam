<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('invoice', 'invoicepdf.invoice1')
    ->middleware(['auth'])
    ->name('invoice');
Route::view('invoice2', 'invoicepdf.invoice2')
    ->middleware(['auth'])
    ->name('invoice');

require __DIR__.'/auth.php';
