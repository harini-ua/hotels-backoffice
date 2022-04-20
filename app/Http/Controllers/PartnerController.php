<?php

namespace App\Http\Controllers;

use App\DataTables\PartnersDataTable;
use App\Http\Requests\PartnerStoreRequest;
use App\Http\Requests\PartnerUpdateRequest;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PartnersDataTable $dataTable
     * @return mixed
     */
    public function index(PartnersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Partners')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Partners')]
        ];

        $actions = [
            ['href' => route('partners.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.partners.index', compact(
            'breadcrumbs',
            'actions',
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
            ['title' => __('Create Partner')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('partners.index'), 'name' => __('All Partners')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.partners.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PartnerStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(PartnerStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $partner = new Partner();
            $partner->fill($request->all());
            $partner->save();

            DB::commit();

            alert()->success($partner->name, __('Partner created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('partners.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Partner $partner)
    {
        $breadcrumbs = [
            ['title' => __('Update Partner')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('partners.index'), 'name' => __('All Partners')],
            ['name' => $partner->name]
        ];

        $actions = [
            ['href' => route('partners.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.partners.update', compact(
            'breadcrumbs',
            'actions',
            'partner',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PartnerUpdateRequest $request
     * @param Partner $partner
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PartnerUpdateRequest $request, Partner $partner)
    {
        try {
            DB::beginTransaction();

            $partner->fill($request->all());
            $partner->internal = $request->has('internal');
            $partner->save();

            DB::commit();

            alert()->success($partner->name, __('Partner updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('partners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Partner $partner
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Partner $partner)
    {
        if ($partner->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
