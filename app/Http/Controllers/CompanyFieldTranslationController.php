<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFieldTranslationRequest;
use App\Models\Company;
use App\Models\CompanyField;
use App\Models\CompanyFieldTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyFieldTranslationController extends Controller
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->only(['company']), [
            'company' => 'sometimes|exists:companies,id',
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['title' => __('Company Site Translations')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Company Site Translations')]
        ];

        $actions = [
            ['href' => route('translations.companies.field.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $companies = Company::all()
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $company = null;

        $result = [];
        $count = 0;
        if ($request->has(['company'])) {
            $company = Company::find($request->get('company'));
            $company->load('language');

            $query = CompanyField::select([
                'company_fields.id AS field_id',
                'company_fields.name AS name',
                'translation.value AS translation',
                'company_fields.is_mobile AS group',
                'company_fields.type AS type',
                'company_fields.max_length AS max_length',
            ]);

            $query->selectRaw($company->id.' AS company_id');

            $translation = DB::table(CompanyFieldTranslation::TABLE_NAME)
                ->select([
                    'field_id',
                    'company_id',
                    DB::raw('translation AS value'),
                ])
                ->where('company_id', $company->id);

            $query->leftJoinSub($translation, 'translation', static function($join) {
                $join->on('company_fields.id', '=', 'translation.field_id');
            });

            $query->groupBy('field_id');

            $result = $query->get();
            $count = $result->count();
        }

        $translations = [];
        foreach ($result as $item) {
            $translations[$item->group][] = $item;
        }

        return view('admin.pages.company-translations.index', compact(
            'breadcrumbs',
            'actions',
            'companies', 'translations', 'company', 'count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyFieldTranslationRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyFieldTranslationRequest $request)
    {
        try {
            DB::beginTransaction();

            $translations = $request->get('translations');

            foreach ($translations as $item) {
                CompanyFieldTranslation::updateOrCreate([
                    'field_id' => $item['field_id'],
                    'company_id' => $request->get('company_id'),
                    'language_id' => $request->get('language_id'),
                ], [
                    'name' => $item['name'],
                    'translation' => $item['translation'],
                ]);

                DB::commit();
            }

            DB::commit();

            alert()->success('Success!', __('Company Field Translations successfully saved.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.companies.index', [
            'company' => $request->get('company_id'),
        ]);
    }
}
