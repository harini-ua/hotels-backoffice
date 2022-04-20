<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyDefaultUpdateRequest;
use App\Models\CompanyDefault;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

            $companyDefault->updateDefaultImage($request->get('logo'), 'logo', $companyDefault->logo);
            $companyDefault->updateDefaultImage($request->get('main_page_picture'), 'main_page_picture', $companyDefault->main_page_picture);
            $companyDefault->updateDefaultImage($request->get('picture_1'), 'picture_1', $companyDefault->picture_1);
            $companyDefault->updateDefaultImage($request->get('picture_2'), 'picture_2', $companyDefault->picture_2);
            $companyDefault->updateDefaultImage($request->get('picture_3'), 'picture_3', $companyDefault->picture_3);
            $companyDefault->updateDefaultImage($request->get('picture_4'), 'picture_4', $companyDefault->picture_4);
            $companyDefault->updateDefaultImage($request->get('picture_5'), 'picture_5', $companyDefault->picture_5);

            DB::commit();

            alert()->success(__('Success'), __('Default data updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('company-default.edit');
    }
}
