<?php

namespace App\Http\Controllers;

use App\DataTables\SearchingByPeriodDataTable;
use App\Models\Company;

class SearchingByPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SearchingByPeriodDataTable $dataTable
     * @return mixed
     */
    public function index(SearchingByPeriodDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Searching Period')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('statistics.index'), 'name' => __('Statistics')],
            ['name' => __('Searching Period')]
        ];

        $actions = [
            [
                'href' => route('statistics.overall-bookings.index'),
                'class' => 'btn-submit',
                'icon' => 'briefcase',
                'name' => __('Overall Bookings'),
            ]
        ];

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.searching-period.index', compact(
            'breadcrumbs', 'actions', 'companies'
        ));
    }
}
