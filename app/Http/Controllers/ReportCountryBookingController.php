<?php

namespace App\Http\Controllers;

use App\DataTables\ReportCountryBookingDataTable;
use App\Enums\BookingDateType;
use App\Enums\BookingPlatform;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Country;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class ReportCountryBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ReportCountryBookingDataTable $dataTable
     * @return mixed
     */
    public function index(ReportCountryBookingDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Country Booking')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Country Booking')]
        ];

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];
        $hotels = [];

        $statuses = BookingStatus::asSelectArray();
        $dataTypes = BookingDateType::asSelectArray();
        $platformTypes = BookingPlatform::asSelectArray();

        $platformVersion = DB::table(Booking::TABLE_NAME)
            ->select('platform_version')
            ->where('platform_version', '!=', '')
            ->whereNotNull('platform_version')
            ->orderBy('platform_version')
            ->distinct()->get()
            ->pluck('platform_version', 'platform_version');

        return $dataTable->render('admin.pages.country-booking.index', compact(
            'breadcrumbs', 'companies', 'countries', 'cities', 'hotels', 'statuses',
            'dataTypes', 'platformTypes', 'platformVersion'
        ));
    }
}
