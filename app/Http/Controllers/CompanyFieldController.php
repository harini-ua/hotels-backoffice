<?php

namespace App\Http\Controllers;

use App\Enums\FieldType;
use App\Enums\VerbalType;
use App\Http\Requests\CompanyFieldStoreRequest;
use App\Models\CompanyField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyFieldController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Company Field')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Create Company Field')]
        ];

        $fieldTypes = FieldType::asSelectArray();
        $verbalType = VerbalType::asSelectArray();

        return view('admin.pages.company-translations.create', compact(
            'breadcrumbs', 'fieldTypes', 'verbalType'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyFieldStoreRequest $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function store(CompanyFieldStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $field = new CompanyField();
            $field->fill($request->all());

            $field->save();

            DB::commit();

            alert()->success($field->name, __('Company filed created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.companies.index');
    }
}
