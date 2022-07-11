<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageTranslationRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageField;
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

        $result = [];
        $count = 0;
        if ($request->has(['page', 'language'])) {
            $page = Country::find($request->get('page'));
            $language = Language::find($request->get('language'));

            $query = PageField::leftJoin(PageFieldTranstation::TABLE_NAME, function($join) {
                $join->on('page_fields.id', '=', 'page_field_translations.field_id');
            });

            $query->where('page_fields.page_id', $request->get('page'));
            $query->where('page_field_translations.language_id', $request->get('language'));

            $query->select([
                'page_field_translations.id AS id',
                'page_fields.id AS field_id',
                'page_fields.page_id AS page_id',
                'page_field_translations.name',
                'page_field_translations.translation',
                'page_fields.is_mobile AS group',
                'page_fields.type AS type',
            ]);

            $result = $query->get();
            $count = $result->count();
        }

        $translations = [];
        foreach ($result as $item) {
            $translations[$item->group][] = $item;
        }

        return view('admin.pages.page-translations.index', compact(
            'breadcrumbs',
            'actions',
            'pages', 'languages', 'page', 'language', 'translations', 'count'
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
