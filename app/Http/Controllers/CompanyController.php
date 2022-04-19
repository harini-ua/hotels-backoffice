<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Enums\DiscountAmountType;
use App\Enums\DiscountCodeType;
use App\Enums\DiscountCommissionType;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\CompanyTemplate;
use App\Models\CompanyTheme;
use App\Models\Country;
use App\Models\DiscountVoucher;
use App\Models\User;
use App\Services\CompanyService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /** @var CompanyService */
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

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

        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.companies.create', compact(
            'breadcrumbs', 'themes', 'templates', 'status', 'categories', 'admins', 'countries'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $company = new Company();
            $company->fill($request->all());
            $company->holder_name = $company->company_name; // TODO: Need to be clarified
            $company->save();

            DB::commit();

            alert()->success($company->name, __('Company created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('admin.pages.companies.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $breadcrumbs = [
            ['title' => __('Edit Company Site')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.companies.update', compact(
            'breadcrumbs', 'actions', 'themes', 'templates', 'status', 'categories', 'admins', 'countries'
        ));
    }

    /**
     * Store a newly duplicate resource in storage.
     *
     * @param Request $request
     * @param Company $company
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function duplicate(Request $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $this->companyService->setCompany($company);
            $this->companyService->duplicate($request->get('company_name'));

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['success' => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        if ($company->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
