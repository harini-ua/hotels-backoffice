<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyThemesDataTable;
use App\Http\Requests\CompanyThemeStoreRequest;
use App\Http\Requests\CompanyThemeUpdateRequest;
use App\Models\CompanyTheme;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CompanyThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CompanyThemesDataTable $dataTable
     * @return mixed
     */
    public function index(CompanyThemesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Company Site Themes')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Themes')]
        ];

        $actions = [
            ['href' => route('companies.themes.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.companies-themes.index', compact(
            'breadcrumbs',
            'actions'
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
            ['title' => __('Create Theme')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.themes.index'), 'name' => __('All Themes')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.companies-themes.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyThemeStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(CompanyThemeStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->has('default')) {
                CompanyTheme::query()->update([
                    'default' => 0
                ]);
            }

            $theme = new CompanyTheme();
            $theme->fill($request->all());
            $theme->default = $request->has('default');
            $theme->save();

            DB::commit();

            alert()->success($theme->name, __('Theme created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.themes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompanyTheme $theme
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(CompanyTheme $theme)
    {
        $breadcrumbs = [
            ['title' => __('Update Theme')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.themes.index'), 'name' => __('All Themes')],
            ['name' => $theme->theme_name]
        ];

        $actions = [
            ['href' => route('companies.themes.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.companies-themes.update', compact(
            'breadcrumbs',
            'actions',
            'theme'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyThemeUpdateRequest $request
     * @param CompanyTheme $theme
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyThemeUpdateRequest $request, CompanyTheme $theme)
    {
        try {
            DB::beginTransaction();

            if ($request->has('default')) {
                CompanyTheme::query()->update([
                    'default' => 0
                ]);
            }

            $theme->fill($request->all());
            $theme->default = $request->has('default');
            $theme->save();

            DB::commit();

            alert()->success($theme->name, __('Theme updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.themes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CompanyTheme $theme
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(CompanyTheme $theme)
    {
        if ($theme->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
