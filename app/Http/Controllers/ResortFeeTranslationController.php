<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResortFeeTpanslationUpdateRequest;
use App\Http\Requests\ResortFeeTranslationStoreRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\ResortFeeTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResortFeeTranslationController extends Controller
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['title' => __('Resort Fee Translations')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Resort Fee Translations')]
        ];

        $actions = [
            ['href' => route('translations.resort-fee.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $language = null;

        $translations = [];
        $count = 0;
        if ($request->has(['language'])) {
            $language = Language::find($request->get('language'));
            $breadcrumbs[] = ['name' => $language->name];

            $query = ResortFeeTranslation::select([
                'resort_fee_translations.country_id',
                'resort_fee_translations.city_id',
                'resort_fee_translations.translation AS name',
                'translation.value AS translation',
            ]);

            $query->with(['country', 'city']);

            $query->selectRaw($language->id.' AS language_id');

            $translation = DB::table(ResortFeeTranslation::TABLE_NAME)
                ->select([
                    'id',
                    DB::raw('translation AS value'),
                ])
                ->where('language_id', $language->id);

            $query->leftJoinSub($translation, 'translation', static function($join) {
                $join->on('resort_fee_translations.id', '=', 'translation.id');
            });

            $english = Language::where('name', 'English')->first();
            $query->where('language_id', $english->id);

            $translations = $query->get();
            $count = $translations->count();
        }

        return view('admin.pages.resort-fee-translations.index', compact(
            'breadcrumbs', 'actions', 'languages', 'language', 'translations', 'count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResortFeeTpanslationUpdateRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(ResortFeeTpanslationUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $translations = $request->get('translations');

            foreach ($translations as $item) {
                ResortFeeTranslation::updateOrCreate([
                    'country_id' => $item['country_id'],
                    'city_id' => $item['city_id'],
                    'language_id' => $request->get('language_id'),
                ], [
                    'translation' => $item['translation'],
                ]);

                DB::commit();
            }

            DB::commit();

            alert()->success('Success!', __('Resort Fee Translations successfully saved.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.resort-fee.index', [
            'company' => $request->get('language_id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Resort Fee Translation')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('translations.resort-fee.index'), 'name' => __('Resort Fee Translation')],
            ['name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = [];

        return view('admin.pages.resort-fee-translations.create', compact(
            'breadcrumbs', 'countries', 'cities'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResortFeeTranslationStoreRequest $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function store(ResortFeeTranslationStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $resortFee = new ResortFeeTranslation();
            $resortFee->fill($request->all());
            $resortFee->language_id = Language::where('name', 'English')->first()->id;

            $resortFee->save();

            DB::commit();

            alert()->success('Success!', __('Resort fee translation created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.resort-fee.index');
    }
}
