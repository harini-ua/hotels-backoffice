<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyDefaultUpdateRequest;
use App\Models\CompanyDefault;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyDefaultController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $breadcrumbs = [
            ['title' => __('Company Site Default')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Company Site Default')]
        ];

        $companyDefault = CompanyDefault::first();

        return view('admin.pages.settings.company-default.update', compact(
            'breadcrumbs', 'companyDefault'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyDefaultUpdateRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyDefaultUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $companyDefault = CompanyDefault::first();
            $companyDefault->fill($request->all());
            $companyDefault->save();

            $companyDefault->saveImage($request->only(CompanyDefault::IMAGE_FIELDS));

            DB::commit();

            alert()->success(__('Success'), __('Default data updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('company-default.edit');
    }
}
