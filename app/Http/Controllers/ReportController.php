<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Reports')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Reports')]
        ];

        return view('admin.pages.reports.index', compact('breadcrumbs'));
    }
}
