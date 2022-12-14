<?php

namespace App\Http\Controllers;

use App\DataTables\OverallBookingsDataTable;
use App\Models\Company;

class OverallBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OverallBookingsDataTable $dataTable
     * @return mixed
     */
    public function index(OverallBookingsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Overall BookingSeeder')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('statistics.index'), 'name' => __('Statistics')],
            ['name' => __('Overall BookingSeeder')]
        ];

        $actions = [
            [
                'href' => route('statistics.searching-period.index'),
                'class' => 'btn-submit',
                'icon' => 'calendar',
                'name' => __('Searching Period'),
            ]
        ];

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.overall-bookings.index', compact(
            'breadcrumbs', 'actions', 'companies'
        ));
    }
}
