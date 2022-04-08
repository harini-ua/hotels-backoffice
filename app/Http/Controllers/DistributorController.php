<?php

namespace App\Http\Controllers;

use App\DataTables\DistributorsDataTable;
use App\Http\Requests\DistributorStoreRequest;
use App\Models\Company;
use App\Models\Distributor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param DistributorStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DistributorStoreRequest $request)
    {
        $distributor = new Distributor();
        $distributor->fill($request->all());
        $distributor->save();

        return redirect()->route('admin.pages.distributors.index');
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
