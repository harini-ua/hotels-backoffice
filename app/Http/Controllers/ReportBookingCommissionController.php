<?php

namespace App\Http\Controllers;

use App\DataTables\ReportBookingCommissionDataTable;
use App\Enums\BookingType;
use App\Models\Company;

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

        $bookingTypes = BookingType::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-commission.index', compact(
            'breadcrumbs', 'bookingTypes', 'companies'
        ));
    }
}
