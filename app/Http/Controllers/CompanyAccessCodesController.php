<?php

namespace App\Http\Controllers;

use App\Enums\AccessCodeType;
use App\Exports\AccessCodesExport;
use App\Http\Requests\CompanyAccessCodesUpdateRequest;
use App\Models\AccessCode;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CompanyAccessCodesController extends Controller
{
    /** @var CompanyService */
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

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

        $accessCodes = $company->accessCodes()
            ->groupBy('created_at')
            ->orderBy('created_at')
            ->get();

        return view('admin.pages.companies.access-codes', compact(
            'breadcrumbs', 'company', 'accessCodes'
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

            $company->access_codes = $request->get('access_codes');
            $company->save();

            $this->companyService->setCompany($company);
            $this->companyService->genegateAccesCodes($company->access_codes, AccessCodeType::UNIQUE);

            DB::commit();

            alert()->success(__('Success'), __('Access codes updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.access-codes.edit', $company);
    }

    /**
     * View the company access codes.
     *
     * @param Company $company
     * @param AccessCode $accessCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Company $company, AccessCode $accessCode)
    {
        $query = $company->accessCodes();
        $query->where('created_at', $accessCode->created_at);

        $accessCodes = $query->get()->pluck('code')->toArray();
        if ($accessCodes) {
            return response()->json([
                'success' => true,
                'codes' => implode('<br />', $accessCodes),
            ]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Download the company access codes.
     *
     * @param Company $company
     * @param AccessCode $accessCode
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Company $company, AccessCode $accessCode)
    {
        return Excel::download(
            new AccessCodesExport($company, $accessCode),
            'access-codes.xlsx'
        );
    }
}
