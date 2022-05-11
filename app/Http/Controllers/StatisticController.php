<?php

namespace App\Http\Controllers;

use App\View\Components\Menu;

class StatisticController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Statistics')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Statistics')]
        ];

        $menu = collect((new Menu())->items);

        $statistics = $menu->where('slag', 'statistics')->first();

        if (isset($statistics['items'])) {
            $statistics = $statistics['items'];
            $statistics = array_chunk($statistics, 6);
        } else {
            $statistics = [];
        }

        return view('admin.pages.statistics.index', compact(
            'breadcrumbs', 'statistics'
        ));
    }
}
