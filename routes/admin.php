<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::middleware('role:admin,distributor,employee')->group(function() {

        /** ----- ------ ----- OTHERS */

        Route::get('/', [DashboardsController::class, 'index'])->name('home');

        /** ----- ------ ----- DASHBOARDS */

        Route::as('dashboards.')->group(function () {
            Route::get('dashboard', [DashboardsController::class, 'index'])->name('index');
            Route::get('/users/dashboard', [DashboardsController::class, 'users'])->name('users');
        });

        /** ----- ------ ----- USERS */

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
        });

        /** ----- ------ ----- ADMINS */

        Route::prefix('admins')->as('admins.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
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
    });
});
