<?php

namespace App\Http\Controllers;

use App\Enums\FieldType;
use App\Enums\VerbalType;
use App\Http\Requests\PageFieldStoreRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageFieldController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Page Field')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Create Page Field')]
        ];

        $pages = Page::all()
            ->sortBy('order')
            ->pluck('name', 'id');

        $fieldTypes = FieldType::asSelectArray();
        $verbalType = VerbalType::asSelectArray();

        return view('admin.pages.page-translations.create', compact(
            'breadcrumbs', 'pages', 'fieldTypes', 'verbalType'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageFieldStoreRequest $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function store(PageFieldStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            //..

            DB::commit();

            alert()->success(__('Success'), __('Page filed created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('translations.pages.index');
    }
}
