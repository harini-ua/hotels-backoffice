<?php

namespace App\Http\Controllers;

use App\DataTables\HotelsDataTable;
use App\Http\Requests\HotelUpdateRequest;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\HotelProvider;
use App\Services\IndexService;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    /** @var IndexService $indexService */
    public $indexService;

    public function __construct(IndexService $indexService)
    {
        $this->indexService = $indexService;
    }

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

            $hotel->blacklisted = $request->has('blacklisted');

            if ($request->filled('position')) {
                $position = str_replace(' ', '', trim($request->get('position')));
                $location = explode(',', $position);
                $hotel->position = new Point($location[0], $location[1]);
            }

            $saved = $hotel->save();

            if ($saved && $hotel->isDirty('blacklisted')) {
                // Add the hotel blacklist for all providers
                $hotel->providers()->update([
                    'blacklisted' => $hotel->blacklisted
                ]);
            }

            DB::commit();

            alert()->success($hotel->name, __('Hotel updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.update', $hotel);
    }

    /**
     * @param Request $request
     * @param Hotel  $hotel
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateAjax(Request $request, Hotel $hotel)
    {
        $hotel->fill($request->all());

        $saved = $hotel->save();

        if ($saved && $hotel->isDirty('blacklisted')) {
            // Add the hotel blacklist for all providers
            $hotel->providers()->update([
                'blacklisted' => $hotel->blacklisted
            ]);
        }

        return response()->json([
            'success' => $saved
        ]);
    }
}
