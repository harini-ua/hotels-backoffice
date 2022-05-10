<?php

namespace App\Http\Controllers;

use App\View\Components\Menu;

class SettingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Settings')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Settings')]
        ];

        $menu = collect((new Menu())->items);
        $settings = $menu->where('slag', 'settings')->first()['items'];
        $settings = array_chunk($settings, 6);

        return view('admin.pages.settings.index', compact('breadcrumbs', 'settings'));
    }
}
