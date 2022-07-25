<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CityCommissionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityTranslationController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CompanyAccessCodesController;
use App\Http\Controllers\CompanyAccountController;
use App\Http\Controllers\CompanyBookingCommissionController;
use App\Http\Controllers\CompanyCommissionController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyExtraNightController;
use App\Http\Controllers\CompanyFieldController;
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
use App\Http\Controllers\CompanyFieldTranslationController;
use App\Http\Controllers\CompanyVatController;
use App\Http\Controllers\CountryCommissionController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DefaultContentController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorUserController;
use App\Http\Controllers\HotelBadgeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelFacilityController;
use App\Http\Controllers\HotelImageController;
use App\Http\Controllers\IpFilterController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OverallBookingsController;
use App\Http\Controllers\PageFieldController;
use App\Http\Controllers\PageFieldTranslationController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PopularHotelController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoMessageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RecommendedHotelController;
use App\Http\Controllers\ReportBookingCommissionController;
use App\Http\Controllers\ReportBookingCustomerController;
use App\Http\Controllers\ReportBookingVatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportCountryBookingController;
use App\Http\Controllers\ReportHotelsNewestController;
use App\Http\Controllers\ReportHotelsSummaryController;
use App\Http\Controllers\ReportInvoiceController;
use App\Http\Controllers\ResortFeeTranslationController;
use App\Http\Controllers\SearchingByPeriodController;
use App\Http\Controllers\SendController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpecialOfferHotelController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\BookingUserController;
use App\Http\Controllers\SubCompaniesController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin,distributor,employee')->group(function () {

        /** ----- ------ ----- OTHERS */
        Route::get('/', DashboardsController::class)->name('home');
        Route::get('dashboard', DashboardsController::class)->name('index');
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');

        /** ----- ------ ----- USERS */
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', UserController::class)->name('index');
        });

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
//            Route::get('{distributor}/users/create', [DistributorUserController::class, 'create'])->name('users.create');

            /** ----- ------ ----- DISTRIBUTOR USERS */
            Route::resource('users', DistributorUserController::class)->except(['show']);
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

            Route::prefix('{company}/sub-companies')->as('sub-companies.')->group(function () {
                Route::get('/edit', [SubCompaniesController::class, 'edit'])->name('edit');
                Route::put('/update', [SubCompaniesController::class, 'update'])->name('update');
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
            Route::get('/', StatisticController::class)->name('index');

            Route::prefix('overall-bookings')->as('overall-bookings.')->group(function () {
                Route::get('/', [OverallBookingsController::class, 'index'])->name('index');
            });

            Route::prefix('searching-period')->as('searching-period.')->group(function () {
                Route::get('/', [SearchingByPeriodController::class, 'index'])->name('index');
            });
        });

        /** ----- ------ ----- HOTELS */
        Route::resource('hotels', HotelController::class)->only(['index', 'edit', 'update']);
        Route::prefix('hotels')->as('hotels.')->group(function () {
            Route::post('/{hotel}/update-ajax', [HotelController::class, 'updateAjax'])->name('update-ajax');

            Route::prefix('{hotel}/images')->as('images.')->group(function () {
                Route::get('/edit', [HotelImageController::class, 'edit'])->name('edit');
                Route::put('/update', [HotelImageController::class, 'update'])->name('update');
            });

            Route::prefix('{hotel}/facilities')->as('facilities.')->group(function () {
                Route::get('/edit', [HotelFacilityController::class, 'edit'])->name('edit');
                Route::put('/update', [HotelFacilityController::class, 'update'])->name('update');
            });
        });

        /** ----- ------ ----- REPORTS */
        Route::prefix('reports')->as('reports.')->group(function () {
            Route::get('/', ReportController::class)->name('index');

            Route::get('/booking-customer', [ReportBookingCustomerController::class, 'index'])->name('booking-customer.index');
            Route::get('/booking-customer/advanced', [ReportBookingCustomerController::class, 'advanced'])->name('booking-customer.advanced.index');

            Route::get('/booking-vat', [ReportBookingVatController::class, 'index'])->name('booking-vat.index');
            Route::get('/booking-vat/advanced', [ReportBookingVatController::class, 'advanced'])->name('booking-vat.advanced.index');

            Route::get('/booking-commission', [ReportBookingCommissionController::class, 'index'])->name('booking-commission.index');
            Route::get('/booking-commission/advanced', [ReportBookingCommissionController::class, 'advanced'])->name('booking-commission.advanced.index');

            Route::get('/invoice', [ReportInvoiceController::class, 'index'])->name('invoice.index');
            Route::get('/invoice/advanced', [ReportInvoiceController::class, 'advanced'])->name('invoice.advanced.index');

            Route::get('/country-booking', [ReportCountryBookingController::class, 'index'])->name('country-booking.index');

            Route::prefix('hotels')->as('hotels.')->group(function () {
                Route::get('summary', [ReportHotelsSummaryController::class, 'index'])->name('summary.index');
                Route::get('newest', [ReportHotelsNewestController::class, 'index'])->name('newest.index');
            });
        });

        /** ----- ------ ----- PRINT */
        Route::prefix('print')->as('print.')->group(function () {
            Route::get('/voucher/{id}', [PrintController::class, 'voucher'])->name('voucher');
            Route::get('/receipt/{id}', [PrintController::class, 'receipt'])->name('receipt');
        });

        /** ----- ------ ----- PAYMENT */
        Route::post('/payment/{id}', [PaymentController::class, 'booking'])->name('payment.booking');

        /** ----- ------ ----- SEND */
        Route::prefix('send')->as('send.')->group(function () {
            Route::get('/booking/{id}/voucher_receipt', [SendController::class, 'bookingVoucherReceipt'])->name('booking.voucher_receipt');
        });

        /** ----- ------ ----- COUNTRIES */
        Route::resource('countries', CountryController::class)->except(['show']);
        Route::prefix('countries')->as('countries.')->group(function () {
            Route::post('/{country}/update/locations', [CountryController::class, 'updateLocations'])->name('update.locations');
            Route::post('/{country}/active', [CountryController::class, 'active'])->name('active');
            Route::get('/{country}/cities', [CountryController::class, 'cities'])->name('cities');
        });

        /** ----- ------ ----- CITIES */
        Route::resource('cities', CityController::class)->except(['show']);
        Route::prefix('cities')->as('cities.')->group(function () {
            Route::post('/{city}/active', [CityController::class, 'active'])->name('active');
            Route::get('/{city}/hotels', [CityController::class, 'hotels'])->name('hotels');
        });

        /** ----- ------ ----- PROMO MESSAGE */
        Route::resource('promo-messages', PromoMessageController::class)->except(['show']);

        /** ----- ------ ----- TRANSLATIONS */
        Route::prefix('translations')->as('translations.')->group(function () {
            Route::get('/', TranslationController::class)->name('index');

            /** ----- ------ ----- COMPANY */
            Route::prefix('companies')->as('companies.')->group(function () {
                Route::get('/', [CompanyFieldTranslationController::class, 'index'])->name('index');
                Route::put('/', [CompanyFieldTranslationController::class, 'update'])->name('update');

                Route::prefix('field')->as('field.')->group(function () {
                    Route::get('create', [CompanyFieldController::class, 'create'])->name('create');
                    Route::post('store', [CompanyFieldController::class, 'store'])->name('store');
                });
            });

            /** ----- ------ ----- PAGES */
            Route::prefix('pages')->as('pages.')->group(function () {
                Route::get('/', [PageFieldTranslationController::class, 'index'])->name('index');
                Route::put('/', [PageFieldTranslationController::class, 'update'])->name('update');

                Route::prefix('field')->as('field.')->group(function () {
                    Route::get('create', [PageFieldController::class, 'create'])->name('create');
                    Route::post('store', [PageFieldController::class, 'store'])->name('store');
                });
            });

            /** ----- ------ ----- CITIES */
            Route::prefix('cities')->as('cities.')->group(function () {
                Route::get('/', [CityTranslationController::class, 'index'])->name('index');
                Route::put('/', [CityTranslationController::class, 'update'])->name('update');
            });

            /** ----- ------ ----- RESORT FEE */
            Route::prefix('resort-fee')->as('resort-fee.')->group(function () {
                Route::get('/', [ResortFeeTranslationController::class, 'index'])->name('index');
                Route::put('/', [ResortFeeTranslationController::class, 'update'])->name('update');

                Route::get('create', [ResortFeeTranslationController::class, 'create'])->name('create');
                Route::post('store', [ResortFeeTranslationController::class, 'store'])->name('store');
            }) ;
        });

        /** ----- ------ ----- SETTINGS */
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', SettingController::class)->name('index');

            /** ----- ------ ----- LANGUAGES */
            Route::resource('languages', LanguageController::class)->except(['show']);
            Route::prefix('languages')->as('languages.')->group(function () {
                Route::post('/{language}/active', [LanguageController::class, 'active'])->name('active');
            });

            /** ----- ------ ----- COMMISSIONS */
            Route::prefix('commissions')->as('commissions.')->group(function () {
                Route::get('/', [CommissionController::class, 'edit'])->name('edit');
                Route::put('/cities/update', [CityCommissionController::class, 'update'])->name('cities.update');
                Route::put('/countries/update', [CountryCommissionController::class, 'update'])->name('countries.update');
            });

            /** ----- ------ ----- POPULAR HOTELS */
            Route::resource('popular-hotels', PopularHotelController::class)->except(['edit', 'update', 'show']);

            /** ----- ------ ----- SPECIAL OFFER HOTELS */
            Route::resource('special-offer-hotels', SpecialOfferHotelController::class)->except(['show']);

            /** ----- ------ ----- RECOMMENDED HOTELS */
            Route::resource('recommended-hotels', RecommendedHotelController::class)->except(['show']);

            /** ----- ------ ----- DEFAULT CONTENT */
            Route::prefix('default-content')->as('default-content.')->group(function () {
                Route::get('/', [DefaultContentController::class, 'edit'])->name('edit');
                Route::put('/', [DefaultContentController::class, 'update'])->name('update');
            });

            /** ----- ------ ----- HOTEL BADGES */
            Route::prefix('hotel-badges')->as('hotel-badges.')->group(function () {
                Route::get('/', [HotelBadgeController::class, 'index'])->name('index');
                Route::get('{hotel}/edit', [HotelBadgeController::class, 'edit'])->name('edit');
                Route::put('{hotel}', [HotelBadgeController::class, 'update'])->name('update');
            });

            /** ----- ------ ----- IP WHITE LIST */
            Route::resource('ip-filter', IpFilterController::class)->except(['show']);
        });

        /** ----- ------ ----- FOR ADMIN SUPPORTED */
        Route::prefix('admin')->as('admin.')->group(function () {
            Route::middleware('role:admin')->group(function () {
                Route::get('/phpinfo', function () {
                    phpinfo(-1);
                });

                Route::get('/monitor', [MonitorController::class, 'index']);
                Route::post('/page-visibility', [MonitorController::class, 'updatePageVisibility']);
            });
        });
    });
});
