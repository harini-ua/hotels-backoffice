<?php

namespace App\Http\Controllers;

use App\DataTables\OverallBookingsDataTable;

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
            ['title' => __('Overall Bookings')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('statistics.index'), 'name' => __('Statistics')],
            ['name' => __('Overall Bookings')]
        ];

        return $dataTable->render('admin.pages.overall-bookings.index', compact('breadcrumbs'));
    }
}
