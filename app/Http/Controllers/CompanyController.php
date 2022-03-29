<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Companies')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Companies')]
        ];

        return view('admin.pages.companies.index', compact('breadcrumbs'));
    }
}
