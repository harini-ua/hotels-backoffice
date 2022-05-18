<?php

namespace App\Http\Controllers;

use App\DataTables\PopularHotelsDataTable;
use App\Enums\HotelStatus;
use App\Enums\Rating;
use App\Http\Requests\PopularHotelStoreRequest;
use App\Http\Requests\PopularHotelUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\PopularHotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PopularHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PopularHotelsDataTable $dataTable
     * @return mixed
     */
    public function index(PopularHotelsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Popular Hotels')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Popular Hotels')]
        ];

        $actions = [
            ['href' => route('settings.popular-hotels.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        $ratings = Rating::getValues();

        return $dataTable->render('admin.pages.popular-hotels.index', compact(
            'breadcrumbs', 'actions', 'countries', 'cities', 'ratings'
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
            ['title' => __('Create Popular Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.popular-hotels.index'), 'name' => __('All Popular Hotels')],
            ['name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];
        $hotels = [];

        $ratings = Rating::getValues();

        return view('admin.pages.popular-hotels.create', compact(
            'breadcrumbs', 'countries', 'cities', 'hotels', 'ratings'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PopularHotelStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(PopularHotelStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $popularHotel = new PopularHotel();
            $popularHotel->fill($request->all());
            $popularHotel->save();

            DB::commit();

            alert()->success('Success!', __('Popular Hotel created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.popular-hotels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PopularHotel $popularHotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(PopularHotel $popularHotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Popular Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.popular-hotels.index'), 'name' => __('All Popular Hotels')],
            ['name' => __('Edit Popular Hotel')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('country_id', $popularHotel->country_id)
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $hotels = Hotel::all()
            ->where('city_id', $popularHotel->city_id)
            ->where('status', HotelStatus::Old)
            ->sortBy('name')
            ->pluck('name', 'id');

        $ratings = Rating::getValues();

        return view('admin.pages.popular-hotels.update', compact(
            'breadcrumbs', 'popularHotel', 'countries', 'cities', 'hotels', 'ratings'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PopularHotelUpdateRequest $request
     * @param PopularHotel $popularHotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PopularHotelUpdateRequest $request, PopularHotel $popularHotel)
    {
        try {
            DB::beginTransaction();

            $popularHotel->fill($request->all());
            $popularHotel->save();

            DB::commit();

            alert()->success('Success!', __('Popular Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.popular-hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PopularHotel $popularHotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(PopularHotel $popularHotel)
    {
        if ($popularHotel->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
