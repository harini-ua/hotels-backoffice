<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::middleware('role:admin,distributor,employee')->group(function() {

        /** ----- ------ ----- OTHERS */
        Route::get('/', [DashboardsController::class, 'index'])->name('home');
        Route::get('dashboard', [DashboardsController::class, 'index'])->name('index');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');

        /** ----- ------ ----- USERS */
        Route::resource('users', UserController::class);
        Route::prefix('users')->as('users.')->group(function () {
            Route::prefix('{user}/password')->as('password.')->group(function () {
                Route::post('change', [UserController::class, 'passwordChange'])->name('change');
                Route::post('send', [UserController::class, 'passwordSend'])->name('send');
            });
        });

        /** ----- ------ ----- ADMINS */
        Route::resource('admins', AdminController::class)->except(['delete']);
        Route::prefix('admins')->as('admins.')->group(function () {
            // TODO: Implement admins routes
        });

        /** ----- ------ ----- DISTRIBUTORS */

        Route::resource('distributors', DistributorController::class)->except(['show']);
        Route::prefix('distributors')->as('distributors.')->group(function () {
            Route::resource('users', DistributorUserController::class)->except(['show']);
            Route::get('{distributor?}/users/create', [DistributorUserController::class, 'create'])
                ->name('users.create');
        });

        /** ----- ------ ----- COMPANIES */

        Route::resource('companies', CompanyController::class);
        Route::prefix('companies')->as('companies.')->group(function () {
            Route::get('{companies}/duplicate', [CompanyController::class, 'duplicate'])->name('duplicate');
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
