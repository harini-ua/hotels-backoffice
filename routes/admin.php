<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

/** ----- ------ ----- USERS */

Route::prefix('users')->as('users.')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

/** ----- ------ ----- DISTRIBUTORS */

Route::prefix('distributors')->as('distributors.')->group(function () {
    Route::get('/', [DistributorController::class, 'index'])->name('index');
});

/** ----- ------ ----- COMPANIES */

Route::prefix('companies')->as('companies.')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('index');
});

/** ----- ------ ----- STATISTICS */

Route::prefix('statistics')->as('statistics.')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('index');
});

/** ----- ------ ----- REPORTS */

Route::prefix('reports')->as('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
});

/** ----- ------ ----- SETTINGS */

Route::prefix('settings')->as('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
});
