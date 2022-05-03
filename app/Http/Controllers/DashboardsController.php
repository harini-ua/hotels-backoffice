<?php

namespace App\Http\Controllers;

class DashboardsController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Dashboard')],
//            ['link' => route('home'), 'name' => __('Home')],
//            ['name' => __('Dashboard')]
        ];

        $actions = [
//            ['icon' => 'plus', 'name' => __('Actions')]
        ];

        return view('admin.index', compact('breadcrumbs', 'actions'));
    }
}
