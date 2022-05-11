<?php

namespace App\Http\Controllers;

use App\DataTables\SearchingByPeriodDataTable;

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
            ['title' => __('Searching By Period')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('statistics.index'), 'name' => __('Statistics')],
            ['name' => __('Searching By Period')]
        ];

        return $dataTable->render('admin.pages.searching-period.index', compact('breadcrumbs'));
    }
}
