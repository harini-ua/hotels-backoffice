<?php

namespace App\Http\Controllers;

use App\View\Components\Menu;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Statistics')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        $menu = collect((new Menu())->items);

        $widgets = $menu->where('slag', 'users')->first();

        if (isset($widgets['items'])) {
            $widgets = $widgets['items'];
            $widgets = array_chunk($widgets, 6);
        } else {
            $widgets = [];
        }

        return view('admin.pages.users.index', compact(
            'breadcrumbs', 'widgets'
        ));
    }
}
