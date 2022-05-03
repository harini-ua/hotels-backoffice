<?php

namespace App\Http\Controllers;

class StatisticController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Statistics')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Statistics')]
        ];

        return view('admin.pages.statistics.index', compact('breadcrumbs'));
    }
}
