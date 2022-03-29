<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Distributors')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Distributors')]
        ];

        return view('admin.pages.distributors.index', compact('breadcrumbs'));
    }
}
