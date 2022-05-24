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

        return view('admin.pages.popular-hotels.create', compact(
            'breadcrumbs', 'countries', 'cities', 'hotels'
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

            $hotel = Hotel::find($request->get('hotel_id'));
            $hotel->popularity = 1;
            $hotel->save();

            DB::commit();

            alert()->success('Success!', __('Popular Hotel created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.popular-hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hotel $popularHotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Hotel $popularHotel)
    {
        $hotel = $popularHotel;
        $hotel->popularity = 0;
        $hotel->save();

        if ($hotel->save()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
