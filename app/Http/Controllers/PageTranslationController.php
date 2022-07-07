<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageTranslationRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageFieldTranstation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageTranslationController extends Controller
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->only(['page', 'language']), [
            'page' => 'sometimes|exists:pages,id',
            'language' => 'sometimes|exists:languages,id',
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['title' => __('Page Translations')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Page Translations')]
        ];

        $actions = [
            ['href' => route('translations.pages.field.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $pages = Page::all()
            ->sortBy('order')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $page = null;
        $language = null;

        $translations = [];
        if ($request->has(['page', 'language'])) {
            $page = Country::find($request->get('page'));
            $language = Language::find($request->get('language'));
        }

        return view('admin.pages.page-translations.index', compact(
            'breadcrumbs',
            'actions',
            'pages', 'languages', 'page', 'language', 'translations'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageTranslationRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PageTranslationRequest $request)
    {
        try {
            DB::beginTransaction();

            $translations = $request->get('translations');

            foreach ($translations as $item) {
                PageFieldTranstation::updateOrCreate([
                    'field_id' => $item->field_id,
                    'page_id' => $request->get('page_id'),
                    'language_id' => $request->get('language_id'),
                ], [
                    'name' => $item->name,
                    'translation' => $item->translation,
                ]);
            }

            DB::commit();

            alert()->success('Success!', __('Page Field Translations successfully saved.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.pages.index', [
            'page' => $request->get('page_id'),
            'language' => $request->get('language_id'),
        ]);
    }
}
