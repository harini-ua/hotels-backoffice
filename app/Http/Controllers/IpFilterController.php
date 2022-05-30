<?php

namespace App\Http\Controllers;

use App\DataTables\IpFilterDataTable;
use App\Http\Requests\IpFilterStoreRequest;
use App\Http\Requests\IpFilterUpdateRequest;
use App\Models\IpFilter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IpFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IpFilterDataTable $dataTable
     * @return mixed
     */
    public function index(IpFilterDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Ip Filter')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['name' => __('Ip Filter')]
        ];

        $actions = [
            ['href' => route('settings.ip-filter.create'), 'icon' => 'plus', 'name' => __('Add IP')]
        ];

        return $dataTable->render('admin.pages.ip-filter.index',
            compact('breadcrumbs', 'actions')
        );
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
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['link' => route('settings.ip-filter.index'), 'name' => __('IP Filter')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.ip-filter.create', compact('breadcrumbs',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IpFilterStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(IpFilterStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $ipFilter = new IpFilter();
            $ipFilter->fill($request->except(['is_expiry', 'expiry']));

            $ipFilter->expiry = null;
            if ($request->has('is_expiry')) {
                $ipFilter->expiry = $request->get('expiry');
            }

            $ipFilter->creator_id = \Auth::user()->id;
            $ipFilter->save();

            DB::commit();

            alert()->success($ipFilter->ip_address, __('IP Filter created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.ip-filter.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param IpFilter $ipFilter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(IpFilter $ipFilter)
    {
        $breadcrumbs = [
            ['title' => __('IP Filter')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['link' => route('settings.ip-filter.index'), 'name' => __('IP Filter')],
            ['name' => $ipFilter->ip_address]
        ];

        $actions = [
            ['href' => route('settings.ip-filter.create'), 'icon' => 'plus', 'name' => __('Add IP')]
        ];

        return view('admin.pages.ip-filter.update',
            compact('breadcrumbs', 'actions', 'ipFilter')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IpFilterUpdateRequest $request
     * @param IpFilter $ipFilter
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(IpFilterUpdateRequest $request, IpFilter $ipFilter)
    {
        try {
            DB::beginTransaction();

            $ipFilter->fill($request->except(['is_expiry', 'expiry']));

            $ipFilter->expiry = null;
            if ($request->has('is_expiry')) {
                $ipFilter->expiry = Carbon::createFromFormat('d/m/Y', $request->get('expiry'));
            }

            $ipFilter->creator_id = \Auth::user()->id;
            $ipFilter->save();

            DB::commit();

            alert()->success($ipFilter->ip_address, __('IP Filter updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.ip-filter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IpFilter $ipFilter
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(IpFilter $ipFilter)
    {
        if ($ipFilter->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
