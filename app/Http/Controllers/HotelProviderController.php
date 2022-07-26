<?php

namespace App\Http\Controllers;

use App\DataTables\HotelsProvidersDataTable;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HotelsProvidersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Hotel Providers')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Hotel Providers')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        $providers = Provider::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.hotels-providers.index', compact(
            'breadcrumbs', 'countries', 'cities', 'providers'
        ));
    }

    /**
     * @param Request $request
     * @param Hotel  $hotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateAjax(Request $request, Hotel $hotel)
    {
        return response()->json([
            'success' => true
        ]);
    }
}
