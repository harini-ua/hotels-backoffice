<?php

namespace App\Http\Controllers;

use App\DataTables\RecommendedHotelsDataTable;
use App\Enums\HotelStatus;
use App\Enums\SortNumber;
use App\Http\Requests\RecommendedHotelStoreRequest;
use App\Http\Requests\RecommendedHotelUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\RecommendedHotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RecommendedHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RecommendedHotelsDataTable $dataTable
     * @return mixed
     */
    public function index(RecommendedHotelsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Recommended Hotels')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Recommended Hotels')]
        ];

        $actions = [
            ['href' => route('settings.recommended-hotels.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        $sortNumbers = SortNumber::getValues();

        return $dataTable->render('admin.pages.recommended-hotels.index', compact(
            'breadcrumbs', 'actions', 'countries', 'cities', 'sortNumbers'
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
            ['title' => __('Create Recommended Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.recommended-hotels.index'), 'name' => __('All Recommend Hotels')],
            ['name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];
        $hotels = [];

        $sortNumbers = SortNumber::getValues();

        return view('admin.pages.recommended-hotels.create', compact(
            'breadcrumbs', 'countries', 'cities', 'hotels', 'sortNumbers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RecommendedHotelStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(RecommendedHotelStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $hotel = Hotel::find($request->get('hotel_id'));
            $hotel->recommended = $request->get('recommended');
            $hotel->save();

            DB::commit();

            alert()->success('Success!', __('Recommended Hotel created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.recommended-hotels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hotel $hotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Hotel $hotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Recommend Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.recommended-hotels.index'), 'name' => __('All Recommend Hotels')],
            ['name' => __('Edit Recommend Hotel')]
        ];

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

        $sortNumbers = SortNumber::getValues();

        return view('admin.pages.recommended-hotels.update', compact(
            'breadcrumbs', 'hotel', 'countries', 'cities', 'hotels', 'sortNumbers'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecommendedHotelUpdateRequest $request
     * @param Hotel $hotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(RecommendedHotelUpdateRequest $request, Hotel $hotel)
    {
        try {
            DB::beginTransaction();

            $hotel->recommended = $request->get('recommended');
            $hotel->save();

            DB::commit();

            alert()->success('Success!', __('Recommended Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.recommended-hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hotel $hotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->recommended = 0;
        $hotel->save();

        if ($hotel->save()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
