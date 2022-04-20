<?php

namespace App\Http\Controllers;

use App\DataTables\ProvidersDataTable;
use App\Http\Requests\ProviderUpdateRequest;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProvidersDataTable $dataTable
     * @return mixed
     */
    public function index(ProvidersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Providers')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Providers')]
        ];

        return $dataTable->render('admin.pages.providers.index', compact('breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Provider $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Provider $provider)
    {
        $breadcrumbs = [
            ['title' => __('Edit Provider')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('providers.index'), 'name' => __('All Providers')],
            ['name' => $provider->name]
        ];

        return view('admin.pages.providers.update', compact('breadcrumbs', 'provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProviderUpdateRequest $request
     * @param Provider $provider
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(ProviderUpdateRequest $request, Provider $provider)
    {
        try {
            DB::beginTransaction();

            $provider->fill($request->all());
            $provider->active = $request->has('active');
            $provider->save();

            DB::commit();

            alert()->success($provider->name, __('Provider updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('providers.index');
    }

    /**
     * @param Provider $provider
     * @return JsonResponse
     * @throws \Exception
     */
    public function active(Provider $provider)
    {
        $provider->active = !$provider->active;
        $provider->save();

        return response()->json(['success' => true]);
    }
}
