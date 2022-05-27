<?php

namespace App\Http\Controllers;

use App\DataTables\HotelsNewestDataTable;

class ReportHotelsNewestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param HotelsNewestDataTable $dataTable
     * @return mixed
     */
    public function index(HotelsNewestDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Hotels Newest')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('reports.index'), 'name' => __('Reports')],
            ['name' => __('Hotels Newest')]
        ];

        $actions = [
            [
                'href' => route('reports.hotels.summary.index'),
                'class' => 'btn-submit',
                'icon' => 'feather icon-home',
                'name' => __('Hotels Summary')
            ]
        ];

        return $dataTable->render('admin.pages.hotels-newest.index', compact(
            'breadcrumbs', 'actions'
        ));
    }
}
