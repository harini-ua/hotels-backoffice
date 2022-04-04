<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function users()
    {
        $breadcrumbs = [
            ['title' => __('Users Dashboard')],
//            ['link' => route('home'), 'name' => __('Home')],
//            ['name' => __('Dashboard')]
        ];

        return view('admin.pages.users.dashboard', compact('breadcrumbs'));
    }
}
