<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelImageUpdateRequest;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $hotel->fill($request->all());
            $hotel->save();

            DB::commit();

            alert()->success($hotel->name, __('Hotel images updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.images.edit', $hotel);
    }
}
