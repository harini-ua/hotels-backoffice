<?php

namespace App\Http\Controllers;

use App\Enums\AccessCodeType;
use App\Http\Requests\CompanyAccessCodesUpdateRequest;
use App\Models\Company;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyAccessCodesController extends Controller
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
            ['title' => __('Company Site Access Codes')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        return view('admin.pages.companies.access-codes.update', compact(
            'breadcrumbs', 'company'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function fixedUpdate(Request $request, Company $company)
    {
        if ((int) $company->login_type === AccessCodeType::FIXED) {
            $accessCode = $company->accessCodes()->first();

            if ($accessCode) {
                $accessCode->code = $request->get('access_code');
                $accessCode->created_at = Carbon::now();

                if ($accessCode->save()) {
                    return response()->json([
                        'success' => true,
                        'created_at' => Formatter::date($accessCode->created_at, 'Y-m-d H:i:s')
                    ]);
                }
            }
        }

        return response()->json(['success' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyAccessCodesUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function uniqueUpdate(CompanyAccessCodesUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            //

            DB::commit();

            alert()->success(__('Success'), __('Access codes updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.access-codes.edit', $company);
    }
}
