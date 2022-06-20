<?php

namespace App\Http\Controllers;

use App\DataTables\ReportBookingCustomerAdvancedDataTable;
use App\DataTables\ReportBookingCustomerDataTable;
use App\Enums\BookingDateType;
use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Models\Company;

class ReportBookingCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ReportBookingCustomerDataTable $dataTable
     * @return mixed
     */
    public function index(ReportBookingCustomerDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Booking Customer')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Booking Customer')]
        ];

        $actions = [
            [
                'href' => route('reports.booking-customer.advanced.index'),
                'class' => 'btn-submit',
                'icon' => 'search',
                'name' => __('Advanced Search')
            ]
        ];

        $bookingTypes = BookingType::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $statuses = BookingStatus::asSelectArray();
        $dataTypes = BookingDateType::asSelectArray();

        return $dataTable->render('admin.pages.booking-customer.index', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'companies', 'statuses', 'dataTypes'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @param ReportBookingCustomerAdvancedDataTable $dataTable
     * @return mixed
     */
    public function advanced(ReportBookingCustomerAdvancedDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Booking Customer')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Booking Customer')]
        ];

        $actions = [
            [
                'href' => route('reports.booking-customer.index'),
                'class' => 'btn-submit',
                'icon' => 'search',
                'name' => __('Quick Search')
            ]
        ];

        $bookingTypes = BookingType::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $statuses = BookingStatus::asSelectArray();
        $dataTypes = BookingDateType::asSelectArray();

        return $dataTable->render('admin.pages.booking-customer.advanced', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'companies', 'statuses', 'dataTypes'
        ));
    }
}
