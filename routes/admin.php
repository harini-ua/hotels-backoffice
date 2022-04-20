<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyDefaultController;
use App\Http\Controllers\CompanyTemplateController;
use App\Http\Controllers\CompanyThemeController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorUserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\BookingUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin,distributor,employee')->group(function () {

        /** ----- ------ ----- OTHERS */
        Route::get('/', [DashboardsController::class, 'index'])->name('home');
        Route::get('dashboard', [DashboardsController::class, 'index'])->name('index');
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');

        /** ----- ------ ----- USERS */
        Route::resource('users', BookingUserController::class);
        Route::prefix('users')->as('users.')->group(function () {
            Route::prefix('{user}/password')->as('password.')->group(function () {
                Route::post('change', [BookingUserController::class, 'passwordChange'])->name('change');
                Route::post('send', [BookingUserController::class, 'passwordSend'])->name('send');
            });
        });

        /** ----- ------ ----- ADMINS */
        Route::resource('admins', AdminUserController::class)->except(['delete']);
        Route::prefix('admins')->as('admins.')->group(function () {
            Route::get('{admin}/qr', [AdminUserController::class, 'qr'])->name('qr');
        });

        /** ----- ------ ----- DISTRIBUTORS */
        Route::resource('distributors', DistributorController::class)->except(['show']);
        Route::prefix('distributors')->as('distributors.')->group(function () {
            Route::resource('users', DistributorUserController::class)->except(['show']);
            Route::get('/{distributor?}/users/create', [DistributorUserController::class, 'create'])
                ->name('users.create');
        });

        /** ----- ------ ----- COMPANIES */
        Route::resource('companies', CompanyController::class)->except(['show']);
        Route::prefix('companies')->as('companies.')->group(function () {
            Route::post('{company}/duplicate', [CompanyController::class, 'duplicate'])->name('duplicate');
            Route::resource('themes', CompanyThemeController::class)->except(['show']);
            Route::resource('templates', CompanyTemplateController::class)->except(['show']);
        });

        /** ----- ------ ----- DISCOUNT VOUCHERS */
        Route::resource('discount-vouchers', DiscountVoucherController::class)->except(['show']);
        Route::prefix('discount-vouchers')->as('discount-vouchers.')->group(function () {
            Route::get('{discountVoucher}/download/codes', [DiscountVoucherController::class, 'download'])->name('download.codes');
        });

        /** ----- ------ ----- PARTNERS */
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::prefix('partners')->as('partners.')->group(function () {
            Route::resource('products', PartnerProductController::class)->except(['show']);
        });

        /** ----- ------ ----- NEWSLETTER */
        Route::prefix('newsletters')->as('newsletters.')->group(function () {
            Route::get('create', [NewsletterController::class, 'create'])->name('create');
            Route::post('store', [NewsletterController::class, 'store'])->name('store');
        });

        /** ----- ------ ----- PROVIDERS */
        Route::resource('providers', ProviderController::class)->except(['create', 'store', 'show', 'delete']);
        Route::prefix('providers')->as('providers.')->group(function () {
            Route::post('{provider}/active', [ProviderController::class, 'active'])->name('active');
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
            Route::prefix('company/default')->as('company-default.')->group(function () {
                Route::get('/', [CompanyDefaultController::class, 'edit'])->name('edit');
                Route::put('/', [CompanyDefaultController::class, 'update'])->name('update');
            });
        });
    });
});
