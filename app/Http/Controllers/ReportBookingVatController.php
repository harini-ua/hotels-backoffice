<?php

namespace App\Http\Controllers;

use App\DataTables\ReportBookingVatDataTable;
use App\Enums\BookingType;
use App\Models\Company;

class ReportBookingVatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ReportBookingVatDataTable $dataTable
     * @return mixed
     */
    public function index(ReportBookingVatDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Booking VAT')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Booking VAT')]
        ];

        $bookingTypes = BookingType::asSelectArray();

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-vat.index', compact(
            'breadcrumbs', 'bookingTypes', 'companies'
        ));
    }
}
