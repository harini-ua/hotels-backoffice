<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyTemplatesDataTable;
use App\Http\Requests\CompanyTemplateStoreRequest;
use App\Http\Requests\CompanyTemplateUpdateRequest;
use App\Models\CompanyTemplate;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CompanyTemplatesDataTable $dataTable
     * @return mixed
     */
    public function index(CompanyTemplatesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Company Site Templates')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Templates')]
        ];

        $actions = [
            ['href' => route('companies.templates.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.companies-templates.index', compact(
            'breadcrumbs', 'actions'
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
            ['title' => __('Company Site Templates')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.templates.index'), 'name' => __('All Templates')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.companies-templates.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyTemplateStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(CompanyTemplateStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $companyTemplate = new CompanyTemplate();
            $companyTemplate->fill($request->all());
            $companyTemplate->save();

            DB::commit();

            alert()->success($companyTemplate->name, __('Template created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.templates.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompanyTemplate $template
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(CompanyTemplate $template)
    {
        $breadcrumbs = [
            ['title' => __('Update Template')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.themes.index'), 'name' => __('All Templates')],
            ['name' => $template->name]
        ];

        $actions = [
            ['href' => route('companies.templates.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.companies-templates.update', compact(
            'breadcrumbs', 'actions', 'template'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyTemplateUpdateRequest $request
     * @param CompanyTemplate $template
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyTemplateUpdateRequest $request, CompanyTemplate $template)
    {
        try {
            DB::beginTransaction();

            $template->fill($request->all());
            $template->save();

            DB::commit();

            alert()->success($template->name, __('Template updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CompanyTemplate $template
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(CompanyTemplate $template)
    {
        if ($template->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
