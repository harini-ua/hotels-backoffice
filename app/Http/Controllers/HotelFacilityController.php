<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelFacilityUpdateRequest;
use App\Models\Facility;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class HotelFacilityController extends Controller
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
            ['title' => __('Edit Hotel Facilities')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('hotels.index'), 'name' => __('All Hotels')],
            ['name' => $hotel->name]
        ];

        $hotel->load('facilities');

        $facilities = Facility::all()->pluck('name', 'id');

        return view('admin.pages.hotels.facilities.update', compact(
            'breadcrumbs', 'hotel', 'facilities'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HotelFacilityUpdateRequest  $request
     * @param  Hotel  $hotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(HotelFacilityUpdateRequest $request, Hotel $hotel)
    {
        try {
            DB::beginTransaction();

            $hotel->facilities()->sync($request->get('facilities'));

            DB::commit();

            alert()->success($hotel->name, __('Hotel facilities updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.facilities.edit', $hotel);
    }
}
