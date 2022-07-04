<?php

namespace App\Http\Controllers;

use App\View\Components\Menu;

class TranslationController extends Controller
{
    public function __invoke()
    {
        $breadcrumbs = [
            ['title' => __('Multilingual')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Multilingual')]
        ];

        $menu = collect((new Menu())->items);

        $widgets = $menu->where('slag', 'translations')->first();

        if (isset($widgets['items'])) {
            $widgets = $widgets['items'];
            $widgets = array_chunk($widgets, 6);
        } else {
            $widgets = [];
        }

        return view('admin.pages.translations.index', compact(
            'breadcrumbs', 'widgets'
        ));
    }
}
