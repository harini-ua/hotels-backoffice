<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CityCommissionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CompanyAccessCodesController;
use App\Http\Controllers\CompanyAccountController;
use App\Http\Controllers\CompanyBookingCommissionController;
use App\Http\Controllers\CompanyCommissionController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyDefaultController;
use App\Http\Controllers\CompanyExtraNightController;
use App\Http\Controllers\CompanyGeneralController;
use App\Http\Controllers\CompanyHomepageController;
use App\Http\Controllers\CompanyHotelDistanceController;
use App\Http\Controllers\CompanyOthersController;
use App\Http\Controllers\CompanyPrefilledOptionController;
use App\Http\Controllers\CompanyCustomerSupportController;
use App\Http\Controllers\CompanySaleOfficeLevel1CommissionController;
use App\Http\Controllers\CompanySaleOfficeLevel2CommissionController;
use App\Http\Controllers\CompanyTemplateController;
use App\Http\Controllers\CompanyThemeController;
use App\Http\Controllers\CompanyVatController;
use App\Http\Controllers\CountryCommissionController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorUserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerProductController;
use App\Http\Controllers\PopularHotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RecommendedHotelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpecialOfferHotelController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\BookingUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin,distributor,employee')->group(function () {

        /** ----- ------ ----- OTHERS */
        Route::get('/', [DashboardsController::class, 'index'])->name('home');
        Route::get('dashboard', [DashboardsController::class, 'index'])->name('index');
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');

        /** ----- ------ ----- BOOKING USERS */
        Route::resource('booking-users', BookingUserController::class)->except(['edit', 'update']);
        Route::prefix('booking-users')->as('booking-users.')->group(function () {
            Route::prefix('{booking-user}/password')->as('password.')->group(function () {
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
            Route::get('{distributor}/companies', [DistributorController::class, 'companies'])->name('companies');
            Route::resource('users', DistributorUserController::class)->except(['show']);
            Route::get('/{distributor?}/users/create', [DistributorUserController::class, 'create'])
                ->name('users.create');
        });

        /** ----- ------ ----- COMPANIES */
        Route::resource('companies', CompanyController::class)->except(['show']);
        Route::prefix('companies')->as('companies.')->group(function () {
            Route::post('{company}/duplicate', [CompanyController::class, 'duplicate'])->name('duplicate');

            Route::prefix('{company}/general')->as('general.')->group(function () {
                Route::get('/edit', [CompanyGeneralController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyGeneralController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/contact')->as('contact.')->group(function () {
                Route::get('/edit', [CompanyContactController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyContactController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/homepage')->as('homepage.')->group(function () {
                Route::get('/edit', [CompanyHomepageController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyHomepageController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/prefilled-options')->as('prefilled-options.')->group(function () {
                Route::get('/edit', [CompanyPrefilledOptionController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyPrefilledOptionController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/commissions')->as('commissions.')->group(function () {
                Route::get('/edit', [CompanyCommissionController::class, 'edit'])->name('edit');
                Route::prefix('sale-office')->as('sale-office.')->group(function () {
                    Route::put('/level/1/update', [CompanySaleOfficeLevel1CommissionController::class, 'update'])->name('update.level.1');
                    Route::put('/level/2/update', [CompanySaleOfficeLevel2CommissionController::class, 'update'])->name('update.level.2');
                });
                Route::put('/booking/update', [CompanyBookingCommissionController::class, 'update'])->name('update.booking');
            });

            Route::prefix('{company}/extra-nights')->as('extra-nights.')->group(function () {
                Route::get('/edit', [CompanyExtraNightController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyExtraNightController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/customer-supports')->as('customer-supports.')->group(function () {
                Route::get('/edit', [CompanyCustomerSupportController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyCustomerSupportController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/vat')->as('vat.')->group(function () {
                Route::get('/edit', [CompanyVatController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyVatController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/hotel-distances')->as('hotel-distances.')->group(function () {
                Route::get('/edit', [CompanyHotelDistanceController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyHotelDistanceController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/account')->as('account.')->group(function () {
                Route::get('/edit', [CompanyAccountController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyAccountController::class, 'update'])->name('update');
            });

            Route::prefix('{company}/access-codes')->as('access-codes.')->group(function () {
                Route::get('/edit', [CompanyAccessCodesController::class, 'edit'])->name('edit');
                Route::post('/fixed/update', [CompanyAccessCodesController::class, 'fixedUpdate'])->name('fixed.update');
                Route::put('/unique/update', [CompanyAccessCodesController::class, 'uniqueUpdate'])->name('unique.update');
                Route::get('/{accessCode}/view', [CompanyAccessCodesController::class, 'view'])->name('view');
                Route::get('/{accessCode}/download', [CompanyAccessCodesController::class, 'download'])->name('download');
            });

            Route::prefix('{company}/others')->as('others.')->group(function () {
                Route::get('/edit', [CompanyOthersController::class, 'edit'])->name('edit');
                Route::put('/update', [CompanyOthersController::class, 'update'])->name('update');
            });

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

        /** ----- ------ ----- COUNTRIES */
        Route::prefix('countries')->as('countries.')->group(function () {
            Route::get('/{country}/cities', [CountryController::class, 'cities'])->name('cities');
        });

        /** ----- ------ ----- CITIES */
        Route::prefix('cities')->as('cities.')->group(function () {
            Route::get('/{city}/hotels', [CityController::class, 'hotels'])->name('hotels');
        });

        /** ----- ------ ----- SETTINGS */
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');

            Route::prefix('commissions')->as('commissions.')->group(function () {
                Route::get('/', [CommissionController::class, 'edit'])->name('edit');
                Route::put('/cities/update', [CityCommissionController::class, 'update'])->name('cities.update');
                Route::put('/countries/update', [CountryCommissionController::class, 'update'])->name('countries.update');
            });

            Route::resource('popular-hotels', PopularHotelController::class)->except(['show']);
            Route::resource('special-offer-hotels', SpecialOfferHotelController::class)->except(['show']);
            Route::resource('recommended-hotels', RecommendedHotelController::class)->except(['show']);

            Route::prefix('company-default')->as('company-default.')->group(function () {
                Route::get('/', [CompanyDefaultController::class, 'edit'])->name('edit');
                Route::put('/', [CompanyDefaultController::class, 'update'])->name('update');
            });
        });
    });
});
