<?php

namespace App\Http\Controllers;

use App\DataTables\HotelsDataTable;
use App\Http\Requests\HotelUpdateRequest;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HotelsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Hotels')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('hotels.index'), 'name' => __('Hotels')],
            ['name' => __('All Hotels')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        return $dataTable->render('admin.pages.hotels.index', compact(
            'breadcrumbs', 'countries', 'cities',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Hotel  $hotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Hotel $hotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('hotels.index'), 'name' => __('All Hotels')],
            ['name' => $hotel->name]
        ];

        $hotel->load([
            'city.country',
        ]);

        return view('admin.pages.hotels.general.update', compact(
            'breadcrumbs', 'hotel'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HotelUpdateRequest $request
     * @param Hotel $hotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(HotelUpdateRequest $request, Hotel $hotel)
    {
        try {
            DB::beginTransaction();

            $hotel->fill($request->all());
            $hotel->save();

            DB::commit();

            alert()->success($hotel->name, __('Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.update', $hotel);
    }
}
