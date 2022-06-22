<?php

namespace App\Http\Controllers;

use App\DataTables\ReportBookingCommissionAdvancedDataTable;
use App\DataTables\ReportBookingCommissionDataTable;
use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Models\Company;
use App\Models\CompanyBookingCommission;
use App\Models\CompanySaleOfficeCommission;

class ReportBookingCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ReportBookingCommissionDataTable $dataTable
     * @return mixed
     */
    public function index(ReportBookingCommissionDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Booking Commission')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Booking Commission')]
        ];

        $actions = [
            [
                'href' => route('reports.booking-commission.advanced.index'),
                'class' => 'btn-submit',
                'icon' => 'search',
                'name' => __('Advanced Search')
            ]
        ];

        $bookingTypes = BookingType::asSelectArray();
        $statuses = BookingStatus::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-commission.index', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'statuses', 'companies'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @param ReportBookingCommissionAdvancedDataTable $dataTable
     * @return mixed
     */
    public function advanced(ReportBookingCommissionAdvancedDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Booking Commission')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Booking Commission')]
        ];

        $actions = [
            [
                'href' => route('reports.booking-commission.index'),
                'class' => 'btn-submit',
                'icon' => 'search',
                'name' => __('Quick Search')
            ]
        ];

        $bookingTypes = BookingType::asSelectArray();
        $statuses = BookingStatus::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-commission.advanced', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'statuses', 'companies'
        ));
    }
}
