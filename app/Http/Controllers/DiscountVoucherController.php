<?php

namespace App\Http\Controllers;

use App\DataTables\DiscountVouchersDataTable;
use App\Enums\DiscountAmountType;
use App\Enums\DiscountCodeType;
use App\Enums\DiscountCommissionType;
use App\Exports\DiscountVoucherCodes;
use App\Http\Requests\DiscountVoucherStoreRequest;
use App\Http\Requests\DiscountVoucherUpdateRequest;
use App\Models\Company;
use App\Models\DiscountVoucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DiscountVoucherController extends Controller
{
    public function index(DiscountVouchersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Discount Vouchers')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Discount Vouchers')]
        ];

        $actions = [
            ['href' => route('discount-vouchers.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $discountVoucherTypes = DiscountCodeType::asSelectArray();
        $commissionTypes = DiscountCommissionType::asSelectArray();

        return $dataTable->render('admin.pages.discount-vouchers.index', compact(
            'breadcrumbs', 'actions', 'companies', 'discountVoucherTypes', 'commissionTypes'
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
            ['title' => __('Create Discount Voucher')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('discount-vouchers.index'), 'name' => __('All Discount Vouchers')],
            ['name' => __('Create')]
        ];

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $codeTypes = DiscountCodeType::asSelectArray();
        $commissionTypes = DiscountCommissionType::asSelectArray();
        $amountTypes = DiscountAmountType::asSelectArray();

        return view('admin.pages.discount-vouchers.create', compact(
            'breadcrumbs', 'companies', 'codeTypes', 'commissionTypes', 'amountTypes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DiscountVoucherStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(DiscountVoucherStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $discountVoucher = new DiscountVoucher();
            $discountVoucher->fill($request->all());

            if ($request->get('voucher_type') == DiscountCodeType::AccessForAll()) {
                $discountVoucher->voucher_codes_count = 1;
            }

            $discountVoucher->save();

            if ($request->get('voucher_type') == DiscountCodeType::Individual()) {
                for ($i = 1; $i <= $request->get('voucher_codes_count'); $i++) {
                    $discountVoucher->codes()->create([
                        'code' => generateDiscountCodes(),
                        'status' => 1 // Default not used code
                    ]);
                }
            }

            if ($request->get('voucher_type') == DiscountCodeType::AccessForAll()) {
                $discountVoucher->codes()->create([
                    'code' => $request->get('voucher_code'),
                    'status' => 1 // Default not used code
                ]);
            }

            DB::commit();

            alert()->success($discountVoucher->name, __('Discount voucher created has been successful.'));
        } catch (\PDOException $e) {
            dd($e);
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('discount-vouchers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DiscountVoucher $discountVoucher
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(DiscountVoucher $discountVoucher)
    {
        $breadcrumbs = [
            ['title' => __('Update Discount Voucher')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('discount-vouchers.index'), 'name' => __('All Discount Vouchers')],
            ['name' => $discountVoucher->name]
        ];

        $actions = [
            ['href' => route('discount-vouchers.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.discount-vouchers.update', compact(
            'breadcrumbs', 'actions', 'discountVoucher'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DiscountVoucherUpdateRequest $request
     * @param DiscountVoucher $discountVoucher
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(DiscountVoucherUpdateRequest $request, DiscountVoucher $discountVoucher)
    {
        try {
            DB::beginTransaction();
            $discountVoucher->fill($request->all());
            $discountVoucher->save();

            DB::commit();

            alert()->success($discountVoucher->name, __('Discount voucher updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('discount-vouchers.index');
    }

    /**
     * Download the discount voucher codes.
     *
     * @param DiscountVoucher $discountVoucher
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(DiscountVoucher $discountVoucher)
    {
        return Excel::download(new DiscountVoucherCodes($discountVoucher), 'codes.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DiscountVoucher $discountVoucher
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(DiscountVoucher $discountVoucher)
    {
        if ($discountVoucher->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
