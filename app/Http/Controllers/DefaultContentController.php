<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultContentUpdateRequest;
use App\Models\DefaultContent;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DefaultContentController extends Controller
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

        $defaultContent = DefaultContent::first();

        return view('admin.pages.default-content.update', compact(
            'breadcrumbs', 'defaultContent'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DefaultContentUpdateRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(DefaultContentUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            /** @var DefaultContent $companyDefault */
            $companyDefault = DefaultContent::first();
            $companyDefault->fill($request->except(DefaultContent::IMAGE_FIELDS));
            $companyDefault->save();

            $companyDefault->updateDefaultImage($request->logo, 'logo', $companyDefault->logo);
            $companyDefault->updateDefaultImage($request->main_page_picture, 'main_page_picture', $companyDefault->main_page_picture);
            $companyDefault->updateDefaultImage($request->picture_1, 'picture_1', $companyDefault->picture_1);
            $companyDefault->updateDefaultImage($request->picture_2, 'picture_2', $companyDefault->picture_2);
            $companyDefault->updateDefaultImage($request->picture_3, 'picture_3', $companyDefault->picture_3);
            $companyDefault->updateDefaultImage($request->picture_4, 'picture_4', $companyDefault->picture_4);
            $companyDefault->updateDefaultImage($request->picture_5, 'picture_5', $companyDefault->picture_5);

            DB::commit();

            alert()->success(__('Success'), __('Default content updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('default-content.edit');
    }
}
