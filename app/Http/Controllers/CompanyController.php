<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(CompaniesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Companies')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Companies')]
        ];

        $actions = [
            ['href' => route('users.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.companies.index', compact(
            'breadcrumbs', 'actions'
        ));
    }
}
