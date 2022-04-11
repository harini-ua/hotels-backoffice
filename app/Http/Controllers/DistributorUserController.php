<?php

namespace App\Http\Controllers;

use App\DataTables\DistributorsDataTable;
use App\Models\Company;
use App\Models\Country;
use App\Models\Language;

class DistributorUserController extends Controller
{
    public function index(DistributorsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Distributor Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        $actions = [
            ['href' => route('distributors.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $companies = Company::all()
            ->where('active', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.distributors.index', compact(
            'breadcrumbs', 'actions', 'companies', 'countries', 'languages'
        ));
    }

}
