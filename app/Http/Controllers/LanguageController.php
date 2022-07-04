<?php

namespace App\Http\Controllers;

use App\DataTables\LanguagesDataTable;
use App\Enums\UserRole;
use App\Http\Requests\DistributorStoreRequest;
use App\Http\Requests\DistributorUpdateRequest;
use App\Http\Requests\LanguageStoreRequest;
use App\Http\Requests\LanguageUpdateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LanguagesDataTable $dataTable
     * @return mixed
     */
    public function index(LanguagesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Languages')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Languages')]
        ];

        $actions = [
            ['href' => route('settings.languages.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.languages.index', compact(
            'breadcrumbs',
            'actions',
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
            ['title' => __('Create Language')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.languages.index'), 'name' => __('Languages')],
            ['name' => __('Create')]
        ];

        $languages = Language::all()->sortBy('name')->pluck('name', 'code');

        return view('admin.pages.languages.create', compact(
            'breadcrumbs', 'languages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DistributorStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(LanguageStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $language = new Language();
            $language->fill($request->all());
            $language->status = 1;
            $language->save();

            DB::commit();

            alert()->success($language->name, __('Language created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.languages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Language $language
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Language $language)
    {
        $breadcrumbs = [
            ['title' => __('Update Language')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.languages.index'), 'name' => __('Languages')],
            ['name' => $language->name]
        ];

        $actions = [
            ['href' => route('settings.languages.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $languages = Language::all()->sortBy('name')->pluck('name', 'code');

        return view('admin.pages.languages.update', compact(
            'breadcrumbs',
            'actions',
            'language',
            'languages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LanguageUpdateRequest $request
     * @param Language $language
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(LanguageUpdateRequest $request, Language $language)
    {
        $language->fill($request->all());
        $language->save();

        try {
            DB::beginTransaction();

            $language->fill($request->all());
            $language->save();

            DB::commit();

            alert()->success($language->name, __('Language updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.languages.index');
    }

    /**
     * @param Language $language
     * @return JsonResponse
     * @throws \Exception
     */
    public function active(Language $language)
    {
        $language->active = !$language->active;
        $language->save();

        return response()->json(['success' => true]);
    }
}
