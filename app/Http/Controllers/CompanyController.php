<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.companies.index', compact(
            'breadcrumbs', 'actions'
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
            ['title' => __('Create Company')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Companies')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.companies.create', compact(
            'breadcrumbs'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CompanyStoreRequest $request)
    {
        $company = new Company();
        $company->fill($request->all());
        $company->save();

        return redirect()->route('admin.pages.companies.index');
    }
}
