<?php

namespace App\Http\Controllers;

use App\DataTables\HotelsSummaryDataTable;

class ReportHotelsSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param HotelsSummaryDataTable $dataTable
     * @return mixed
     */
    public function index(HotelsSummaryDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Hotels Summary')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Hotels Summary')]
        ];

        $actions = [
            [
                'href' => route('reports.hotels.newest.index'),
                'class' => 'btn-submit',
                'icon' => 'feather icon-home',
                'name' => __('Hotels Newest')
            ]
        ];

        return $dataTable->render('admin.pages.hotels-summary.index', compact(
            'breadcrumbs', 'actions'
        ));
    }
}
