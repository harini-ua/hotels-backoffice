<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('admin.pages.resort-fee-translations.index', compact(
            'breadcrumbs',
        ));
    }
}
