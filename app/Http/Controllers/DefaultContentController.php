<?php

namespace App\Http\Controllers;

use App\Enums\TeaserType;
use App\Http\Requests\DefaultContentUpdateRequest;
use App\Models\CompanyCarouselItem;
use App\Models\CompanyTeaserItem;
use App\Models\DefaultContent;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

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
            ['title' => __('Default Content')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Default Content')]
        ];

        $defaultContent = DefaultContent::with([
            'carousel.items',
            'teaser.items',
        ])->first();

        /** @var CompanyCarouselItem[] $carousels */
        $carousels = $defaultContent->carousel->items;

        /** @var CompanyTeaserItem[] $teasers */
        $teasers = $defaultContent->teaser->items;
        $teaserTypes = TeaserType::asSelectArray();

        return view('admin.pages.default-content.update', compact(
            'breadcrumbs', 'defaultContent', 'carousels', 'teasers', 'teaserTypes'
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

            // Update default content
            /** @var DefaultContent $defaultContent */
            $defaultContent = DefaultContent::first();
            $defaultContent->fill($request->only(DefaultContent::FIELDS));
            $defaultContent->save();

            // Upload default content image
            foreach (DefaultContent::IMAGE_FIELDS as $field) {
                if ($defaultContent->{$field}) {
                    $imageUpload = $request->file($field);

                    if (Storage::exists('public/default/'.$defaultContent->{$field})) {
                        Storage::delete('public/default/'.$defaultContent->{$field});
                    }

                    $path = storage_path('app/public/default/');

                    $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                    $imageUpload->move($path, $fileName);
                    $defaultContent->update([ $field => $fileName ]);
                }
            }

            DB::commit();

            $carousels = $request->all()['carousels'];

            // Delete carousel items
            $carouselItemsIds = $defaultContent->carousel->items->pluck('id')->toArray();
            $deletedCarouselItems = array_diff($carouselItemsIds, array_column($carousels, 'id'));

            foreach ($deletedCarouselItems as $id) {
                $carouselItem = CompanyCarouselItem::find($id);

                foreach (CompanyCarouselItem::IMAGE_FIELDS as $field) {
                    $carouselItem->deleteDefaultImage($carouselItem->{$field});

                    if (Storage::exists('public/default/'.$carouselItem->{$field})) {
                        Storage::delete('public/default/'.$carouselItem->{$field});
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
                    $carouselItem->carousel_id = $defaultContent->carousel->id;
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

                        if (Storage::exists('public/default/'.$carouselItem->{$field})) {
                            Storage::delete('public/default/'.$carouselItem->{$field});
                        }

                        $path = storage_path('app/public/default/');

                        $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                        $imageUpload->move($path, $fileName);
                        $carouselItem->update([ $field => $fileName ]);
                    }
                }
            }

            DB::commit();

            $teasers = $request->all()['teasers'];

            // Delete teaser items
            $teaserItemsIds = $defaultContent->teaser->items->pluck('id')->toArray();
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
                    $teaserItem->teaser_id = $defaultContent->teaser->id;
                }

                $teaserItem->fill($item);
                $teaserItem->save();
            }

            DB::commit();

            alert()->success(__('Success'), __('Default content updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.default-content.edit');
    }
}
