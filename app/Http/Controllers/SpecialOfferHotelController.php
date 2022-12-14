<?php

namespace App\Http\Controllers;

use App\DataTables\SpecialOfferHotelsDataTable;
use App\Enums\HotelStatus;
use App\Http\Requests\SpecialOfferHotelStoreRequest;
use App\Http\Requests\SpecialOfferHotelUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SpecialOfferHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SpecialOfferHotelsDataTable $dataTable
     * @return mixed
     */
    public function index(SpecialOfferHotelsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Special Offer Hotels')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Special Offer Hotels')]
        ];

        $actions = [
            ['href' => route('settings.special-offer-hotels.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        return $dataTable->render('admin.pages.special-offer-hotels.index', compact(
            'breadcrumbs', 'actions', 'countries', 'cities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Special Offer Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.special-offer-hotels.index'), 'name' => __('All Special Offer Hotels')],
            ['name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];
        $hotels = [];

        return view('admin.pages.special-offer-hotels.create', compact(
            'breadcrumbs', 'countries', 'cities', 'hotels'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SpecialOfferHotelStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(SpecialOfferHotelStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $hotel = Hotel::find($request->get('hotel_id'));
            $hotel->special_offer = $request->get('special_offer');
            $hotel->save();

            DB::commit();

            alert()->success('Success!', __('Special Offer Hotel created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.special-offer-hotels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hotel $specialOfferHotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Hotel $specialOfferHotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Special Offer Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.special-offer-hotels.index'), 'name' => __('All Special Offer Hotels')],
            ['name' => __('Edit Special Offer Hotel')]
        ];

        $hotel = $specialOfferHotel;
        $hotel->load(['city.country']);

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('country_id', $hotel->city->country->id)
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $hotels = Hotel::all()
            ->where('city_id', $hotel->city->id)
            ->where('status', HotelStatus::Old)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.special-offer-hotels.update', compact(
            'breadcrumbs', 'hotel', 'countries', 'cities', 'hotels'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SpecialOfferHotelUpdateRequest $request
     * @param Hotel $specialOfferHotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(SpecialOfferHotelUpdateRequest $request, Hotel $specialOfferHotel)
    {
        try {
            DB::beginTransaction();

            $hotel = $specialOfferHotel;
            $hotel->special_offer = $request->get('special_offer');
            $hotel->save();

            DB::commit();

            alert()->success('Success!', __('Special Offer Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.special-offer-hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hotel $specialOfferHotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Hotel $specialOfferHotel)
    {
        $hotel = $specialOfferHotel;
        $hotel->special_offer = 0;
        $hotel->save();

        if ($hotel->save()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
