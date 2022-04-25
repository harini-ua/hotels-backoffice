<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyHotelDistanceUpdateRequest;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyHotelDistanceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $breadcrumbs = [
            ['title' => __('Edit Company Hotel Distances')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.companies.hotel-distances',
            compact('breadcrumbs', 'actions', 'company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyHotelDistanceUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyHotelDistanceUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->mainOptions()->update([
                'hotel_distances_filter' => ''
            ]);

            DB::commit();

            alert()->success(__('Success'), __('Hotel distance updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.hotel-distances.edit');
    }
}
