<?php

namespace App\Http\Controllers;

use App\DataTables\ReportBookingCustomerDataTable;
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

        $bookingTypes = BookingType::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-customer.index', compact(
            'breadcrumbs', 'bookingTypes', 'companies'
        ));
    }
}
