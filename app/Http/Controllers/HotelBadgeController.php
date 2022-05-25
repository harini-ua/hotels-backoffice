<?php

namespace App\Http\Controllers;

use App\DataTables\HotelBadgesDataTable;
use App\Enums\SortNumber;
use App\Http\Requests\HotelBadgesUpdateRequest;
use App\Models\Country;
use App\Models\Hotel;
use App\Services\IndexService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class HotelBadgeController extends Controller
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
     * @param HotelBadgesDataTable $dataTable
     * @return mixed
     */
    public function index(HotelBadgesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Hotel Badges')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Hotel Badges')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        return $dataTable->render('admin.pages.hotel-badges.index', compact(
            'breadcrumbs', 'countries', 'cities'
        ));
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
            ['title' => __('Edit Hotel Badges')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.hotel-badges.index'), 'name' => __('Hotel Badges')],
            ['name' => $hotel->name],
            ['name' => __('Edit Hotel Badges')]
        ];

        $sortNumbers = SortNumber::getValues();

        return view('admin.pages.hotel-badges.update', compact(
            'breadcrumbs', 'hotel', 'sortNumbers'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HotelBadgesUpdateRequest $request
     * @param Hotel $hotel
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(HotelBadgesUpdateRequest $request, Hotel $hotel)
    {
        try {
            DB::beginTransaction();

            $hotel->fill($request->except('blacklisted'));
            $hotel->blacklisted = $request->has('blacklisted');
            $hotel->save();

            if ($hotel->isDirty('blacklisted')) {
//                $this->indexService->change($hotel, !$request->has('blacklisted'));
            }

            DB::commit();

            alert()->success('Success!', __('Hotel Badges updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.hotel-badges.index');
    }
}
