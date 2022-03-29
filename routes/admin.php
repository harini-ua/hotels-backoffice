<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('users')->as('users.')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
