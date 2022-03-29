<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
