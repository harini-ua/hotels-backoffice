<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyTemplateController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Company Site Templates')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Templates')]
        ];

        $actions = [
            ['href' => route('companies.templates.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];
    }
}
