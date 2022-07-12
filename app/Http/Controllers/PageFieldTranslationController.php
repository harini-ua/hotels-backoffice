<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageFieldTranslationRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageField;
use App\Models\PageFieldTranstation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageFieldTranslationController extends Controller
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
            $page = Page::find($request->get('page'));
            $breadcrumbs[] = ['name' => $page->name];

            $language = Language::find($request->get('language'));
            $breadcrumbs[] = ['name' => $language->name];

            $query = PageField::select([
                'page_fields.id AS field_id',
                'page_fields.page_id AS page_id',
                'page_fields.name',
                'translation.value AS translation',
                'page_fields.is_mobile AS group',
                'page_fields.type AS type',
                'page_fields.max_length AS max_length',
            ]);

            $query->selectRaw($language->id.' AS language_id');

            $translation = DB::table(PageFieldTranstation::TABLE_NAME)
                ->select([
                    'page_id',
                    'field_id',
                    'language_id',
                    DB::raw('translation AS value'),
                ])
                ->where('page_id', $page->id)
                ->where('language_id', $language->id);

            $query->leftJoinSub($translation, 'translation', static function($join) {
                $join->on('page_fields.id', '=', 'translation.field_id');
            });

            $query->groupBy('field_id');

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
     * @param PageFieldTranslationRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PageFieldTranslationRequest $request)
    {
        try {
            DB::beginTransaction();

            $translations = $request->get('translations');

            foreach ($translations as $item) {
                PageFieldTranstation::updateOrCreate([
                    'field_id' => $item['field_id'],
                    'page_id' => $request->get('page_id'),
                    'language_id' => $request->get('language_id'),
                ], [
                    'name' => $item['name'],
                    'translation' => $item['translation'],
                ]);

                DB::commit();
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
