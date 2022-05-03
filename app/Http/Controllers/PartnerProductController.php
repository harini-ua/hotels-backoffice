<?php

namespace App\Http\Controllers;

use App\DataTables\PartnerProductsDataTable;
use App\Http\Requests\PartnerProductStoreRequest;
use App\Http\Requests\PartnerProductUpdateRequest;
use App\Models\Currency;
use App\Models\MealPlan;
use App\Models\Partner;
use App\Models\PartnerProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PartnerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PartnerProductsDataTable $dataTable
     * @return mixed
     */
    public function index(PartnerProductsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Partner Products')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Partner Products')]
        ];

        $actions = [
            ['href' => route('partners.products.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $partners = Partner::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $mealPlans = MealPlan::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $currencies = Currency::all()
            ->sortBy('code')
            ->pluck('code', 'id');

        return $dataTable->render('admin.pages.partners-products.index', compact(
            'breadcrumbs',
            'actions',
            'partners',
            'mealPlans',
            'currencies'
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
            ['title' => __('Create Partner Product')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('partners.products.index'), 'name' => __('All Partner Product')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.partners-products.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PartnerProductStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(PartnerProductStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $partnerProduct = new PartnerProduct();
            $partnerProduct->fill($request->all());
            $partnerProduct->save();

            DB::commit();

            alert()->success($partnerProduct->name, __('Partner product created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('partners.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PartnerProduct $partnerProduct
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(PartnerProduct $partnerProduct)
    {
        $breadcrumbs = [
            ['title' => __('Update Partner Product')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('partners.products.index'), 'name' => __('All Partner Products')],
            ['name' => $partnerProduct->name]
        ];

        $actions = [
            ['href' => route('partners.products.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.partners-products.update', compact(
            'breadcrumbs',
            'actions',
            'partnerProduct',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PartnerProductUpdateRequest $request
     * @param PartnerProduct $partnerProduct
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PartnerProductUpdateRequest $request, PartnerProduct $partnerProduct)
    {
        try {
            DB::beginTransaction();

            $partnerProduct->fill($request->all());
            $partnerProduct->save();

            DB::commit();

            alert()->success($partnerProduct->name, __('Partner product updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('partners.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PartnerProduct $partnerProduct
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(PartnerProduct $partnerProduct)
    {
        if ($partnerProduct->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
