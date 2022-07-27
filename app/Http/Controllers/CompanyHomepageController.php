<?php

namespace App\Http\Controllers;

use App\Enums\TeaserType;
use App\Http\Requests\CompanyHomepageUpdateRequest;
use App\Models\Company;
use App\Models\CompanyCarouselItem;
use App\Models\CompanyHomepageOption;
use App\Models\CompanyTeaserItem;
use App\Models\CompanyTheme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class CompanyHomepageController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $breadcrumbs = [
            ['title' => __('Edit Company Site Homepage')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $company->load([
            'homepageOptions.carousel.items',
            'homepageOptions.teaser.items'
        ]);

        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->map(static function ($theme) {
                return [
                    'id' => $theme->id,
                    'theme_name' => !$theme->default
                        ? $theme->theme_name
                        : $theme->theme_name.' ('.__('Default').')',
                ];
            })
            ->pluck('theme_name', 'id');

        $homepageOptions = $company->homepageOptions;
        $teaserTypes = TeaserType::asSelectArray();

        return view('admin.pages.companies.homepage',
            compact('breadcrumbs', 'actions', 'company', 'themes', 'homepageOptions', 'teaserTypes')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyHomepageUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyHomepageUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $homepageOptions = $company->homepageOptions;

            $company->homepageOptions()
                ->update($request->only(['theme_id']));

            foreach (CompanyHomepageOption::IMAGE_FIELDS as $field) {
                if ($homepageOptions->{$field}) {
                    $imageUpload = $request->file($field);

                    if (Storage::exists('public/companies/'.$company->id.'/'.$homepageOptions->{$field})) {
                        Storage::delete('public/companies/'.$company->id.'/'.$homepageOptions->{$field});
                    }

                    $path = storage_path('app/public/companies/'.$company->id.'/');

                    $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                    $imageUpload->move($path, $fileName);
                    $homepageOptions->update([ $field => $fileName ]);
                }
            }

            DB::commit();

            $carousels = $request->all()['carousels'];

            $carouselItemsIds = $homepageOptions->carousel->items->pluck('id')->toArray();
            $deletedCarouselItems = array_diff($carouselItemsIds, array_column($carousels, 'id'));

            foreach ($deletedCarouselItems as $id) {
                $carouselItem = CompanyCarouselItem::find($id);

                foreach (CompanyCarouselItem::IMAGE_FIELDS as $field) {
                    if (Storage::exists('public/companies/'.$company->id.'/'.$carouselItem->{$field})) {
                        Storage::delete('public/companies/'.$company->id.'/'.$carouselItem->{$field});
                    }
                }

                $carouselItem->delete();
            }

            foreach ($carousels as $item) {
                // Update
                if (isset($item['id'])) {
                    $carouselItem = CompanyCarouselItem::find($item['id']);
                }
                // Or create
                else {
                    $carouselItem = new CompanyCarouselItem();
                    $carouselItem->carousel_id = $homepageOptions->carousel->id;
                }

                // Build images array
                $images = [];
                foreach (CompanyCarouselItem::IMAGE_FIELDS as $field) {
                    if (isset($item[$field])) {
                        $images[$field] = $item[$field];
                        unset($item[$field]);
                    }
                }

                $carouselItem->fill($item);
                $carouselItem->save();

                // Upload carouse item image
                foreach (CompanyCarouselItem::IMAGE_FIELDS as $field) {
                    if (isset($images[$field])) {
                        $imageUpload = $images[$field];

                        if (Storage::exists('public/companies/'.$company->id.'/'.$carouselItem->{$field})) {
                            Storage::delete('public/companies/'.$company->id.'/'.$carouselItem->{$field});
                        }

                        $path = storage_path('app/public/companies/'.$company->id.'/');

                        $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                        $imageUpload->move($path, $fileName);
                        $carouselItem->update([ $field => $fileName ]);
                    }
                }
            }

            DB::commit();

            $teasers = $request->all()['teasers'];

            // Delete teaser items
            $teaserItemsIds = $homepageOptions->teaser->items->pluck('id')->toArray();
            $deletedTeaserItems = array_diff($teaserItemsIds, array_column($teasers, 'id'));
            CompanyTeaserItem::whereIn('id', $deletedTeaserItems)->delete();

            foreach ($teasers as $item) {
                // Update
                if (isset($item['id'])) {
                    $teaserItem = CompanyTeaserItem::find($item['id']);
                }
                // Or create
                else {
                    $teaserItem = new CompanyTeaserItem();
                    $teaserItem->teaser_id = $homepageOptions->teaser->id;
                }

                $teaserItem->fill($item);
                $teaserItem->save();
            }

            DB::commit();

            alert()->success(__('Success'), __('Homepage updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.homepage.edit', $company);
    }
}
