<?php

namespace App\Http\Controllers;

use App\DataTables\DistributorsDataTable;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DistributorController extends Controller
{
    public function index(DistributorsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('List Distributors')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Distributors')]
        ];

        $actions = [
            ['href' => route('distributors.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.distributors.index', compact(
            'breadcrumbs', 'actions', 'companies'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Distributor')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('distributors.index'), 'name' => __('Distributors')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.distributors.create', compact(
            'breadcrumbs'
        ));
    }
}
