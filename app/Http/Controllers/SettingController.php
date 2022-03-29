<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Settings')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Settings')]
        ];

        return view('admin.pages.settings.index', compact('breadcrumbs'));
    }
}
