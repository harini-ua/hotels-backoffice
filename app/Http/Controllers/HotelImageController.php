<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelImageUpdateRequest;
use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class HotelImageController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Hotel  $hotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Hotel $hotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Hotel Images')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('hotels.index'), 'name' => __('All Hotels')],
            ['name' => $hotel->name]
        ];

        $hotel->load('images');

        return view('admin.pages.hotels.images.update', compact(
            'breadcrumbs', 'hotel'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HotelImageUpdateRequest  $request
     * @param  Hotel  $hotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(HotelImageUpdateRequest $request, Hotel $hotel)
    {
        try {
            DB::beginTransaction();

            $images = $request->all()['images'];

            $imageIds = $hotel->images()->pluck('id')->toArray();
            $deletedImages = array_diff($imageIds, array_column($images, 'id'));

            foreach ($deletedImages as $id) {
                $hotelImage = HotelImage::find($id);

                if (!filter_var($hotelImage->image, FILTER_VALIDATE_URL)) {
                    if (Storage::exists('public/hotels/'.$hotel->id.'/'.$hotelImage->image)) {
                        Storage::delete('public/hotels/'.$hotel->id.'/'.$hotelImage->image);
                    }
                }

                $hotelImage->delete();
            }

            foreach ($images as $image) {
                // Update
                if (isset($image['id'])) {
                    $hotelImage = HotelImage::find($image['id']);
                }
                // Or create
                else {
                    $hotelImage = new HotelImage();
                    $hotelImage->hotel_id = $hotel->id;
                }

                $hotelImage->primary = 0;
                $hotelImage->fill($image);

                if (isset($image['image'])) {
                    // Delete old image
                    if (!filter_var($hotelImage->image, FILTER_VALIDATE_URL)) {
                        if (Storage::exists('public/hotels/'.$hotel->id.'/'.$hotelImage->image)) {
                            Storage::delete('public/hotels/'.$hotel->id.'/'.$hotelImage->image);
                        }
                    }

                    // Store new image
                    $image = $image['image'];
                    $path = storage_path('app/public/hotels/'.$hotel->id.'/');
                    $fileName = Uuid::uuid1().'.'.$image->extension();
                    $image->move($path, $fileName);

                    $hotelImage->image = $fileName;
                }

                $hotelImage->save();
            }

            DB::commit();

            alert()->success($hotel->name, __('Hotel images updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.images.edit', $hotel);
    }
}
