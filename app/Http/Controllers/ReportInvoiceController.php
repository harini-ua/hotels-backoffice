<?php

namespace App\Http\Controllers;

use App\DataTables\ReportInvoiceAdvancedDataTable;
use App\DataTables\ReportInvoiceDataTable;
use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Models\Company;

class ReportInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ReportInvoiceDataTable $dataTable
     * @return mixed
     */
    public function index(ReportInvoiceDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Invoice Report')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Invoice Report')]
        ];

        $actions = [
            [
                'href' => route('reports.invoice.advanced.index'),
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

        return $dataTable->render('admin.pages.report-invoice.index', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'statuses', 'companies'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @param ReportInvoiceAdvancedDataTable $dataTable
     * @return mixed
     */
    public function advanced(ReportInvoiceAdvancedDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Invoice Report')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Invoice Report')]
        ];

        $actions = [
            [
                'href' => route('reports.invoice.index'),
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

        return $dataTable->render('admin.pages.report-invoice.advanced', compact(
            'breadcrumbs', 'actions', 'bookingTypes', 'statuses', 'companies'
        ));
    }
}
