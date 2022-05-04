<?php

namespace App\Http\Controllers;

use App\DataTables\RecommendedHotelsDataTable;
use App\Enums\SortNumber;
use App\Http\Requests\RecommendedHotelStoreRequest;
use App\Http\Requests\RecommendedHotelUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\RecommendHotel;
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
            ['title' => __('Recommend Hotels')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Recommend Hotels')]
        ];

        $actions = [
            ['href' => route('settings.recommended-hotels.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $hotels = Hotel::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $sortNumbers = SortNumber::getValues();

        return $dataTable->render('admin.pages.recommended-hotels.index', compact(
            'breadcrumbs', 'actions', 'countries', 'cities', 'hotels', 'sortNumbers'
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
            ['title' => __('Create Recommend Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.recommended-hotels.index'), 'name' => __('All Recommend Hotels')],
            ['name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $hotels = Hotel::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

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

            $recommendHotel = new RecommendHotel();
            $recommendHotel->fill($request->all());
            $recommendHotel->save();

            DB::commit();

            alert()->success('Success!', __('Recommend Hotel created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.recommended-hotels.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecommendedHotelUpdateRequest $request
     * @param RecommendHotel $recommendHotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(RecommendedHotelUpdateRequest $request, RecommendHotel $recommendHotel)
    {
        try {
            DB::beginTransaction();

            $recommendHotel->fill($request->all());
            $recommendHotel->save();

            DB::commit();

            alert()->success('Success!', __('Recommend Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.recommended-hotels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RecommendHotel $recommendHotel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(RecommendHotel $recommendHotel)
    {
        $breadcrumbs = [
            ['title' => __('Edit Recommend Hotel')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.recommended-hotels.index'), 'name' => __('All Recommend Hotels')],
            ['name' => __('Edit Recommend Hotel')]
        ];

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $sortNumbers = SortNumber::getValues();

        return view('admin.pages.settings.recommended-hotels.update', compact(
            'breadcrumbs', 'recommendHotel', 'countries', 'cities', 'sortNumbers'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RecommendHotel $recommendHotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(RecommendHotel $recommendHotel)
    {
        if ($recommendHotel->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
