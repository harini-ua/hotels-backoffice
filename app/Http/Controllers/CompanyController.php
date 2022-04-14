<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CompaniesDataTable $dataTable
     * @return mixed
     */
    public function index(CompaniesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Company Sites')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Company Sites')]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $status = CompanyStatus::asSelectArray();
        $categories = CompanyCategory::asSelectArray();

        return $dataTable->render('admin.pages.companies.index', compact(
            'breadcrumbs', 'actions', 'status', 'categories'
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
            ['title' => __('Create Company Site')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => __('Create')]
        ];

        $status = CompanyStatus::asSelectArray();
        $categories = CompanyCategory::asSelectArray();
        $admins = User::whereHas("roles", function($q) {
                $q->where("name", "admin");
            })->where('status', 1)->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id')
        ;

        return view('admin.pages.companies.create', compact(
            'breadcrumbs', 'status', 'categories', 'admins'
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
