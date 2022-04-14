<?php

namespace App\Http\Controllers;

use App\DataTables\DistributorsDataTable;
use App\Http\Requests\DistributorStoreRequest;
use App\Http\Requests\DistributorUpdateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Language;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DistributorsDataTable $dataTable
     * @return mixed
     */
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

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.distributors.index', compact(
            'breadcrumbs', 'actions', 'companies', 'countries', 'languages'
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

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return view('admin.pages.distributors.create', compact(
            'breadcrumbs', 'countries', 'languages', 'companies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DistributorStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(DistributorStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $distributor = new Distributor();
            $distributor->fill($request->only('name'));
            $distributor->status = 1; // Status active
            $distributor->save();

            $user = new User();
            $user->fill($request->except('name'));
            $user->password = Hash::make($request->get('password'));
            $user->master = true;
            $user->save();

            $user->assignRole('distributor');

            $distributor->users()->attach($user->id);

            DB::commit();

            alert()->success($distributor->name, __('Distributor created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('distributors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Distributor $distributor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Distributor $distributor)
    {
        $breadcrumbs = [
            ['title' => __('Update Distributors')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('distributors.index'), 'name' => __('Distributors')],
            ['name' => $distributor->name]
        ];

        $actions = [
            ['href' => route('distributors.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $master = $distributor->users()->where('master', true)->first();

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return view('admin.pages.distributors.update', compact(
            'breadcrumbs', 'actions', 'distributor', 'master', 'countries', 'languages', 'companies'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DistributorUpdateRequest $request
     * @param Distributor $distributor
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(DistributorUpdateRequest $request, Distributor $distributor)
    {
        $distributor->fill($request->only('name'));
        $distributor->save();

        try {
            DB::beginTransaction();

            $distributor->fill($request->only('name'));
            $distributor->save();

            $master = $distributor->users()->where('master', true)->first();
            $master->fill($request->except('name'));

            if ($request->has('password')) {
                $master->password = Hash::make($request->get('password'));
            }

            $master->save();

            DB::commit();

            alert()->success($distributor->name, __('Distributor updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('distributors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Distributor $distributor
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Distributor $distributor)
    {
        if ($distributor->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
