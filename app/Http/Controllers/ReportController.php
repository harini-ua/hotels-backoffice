<?php

namespace App\Http\Controllers;

use App\View\Components\Menu;

class ReportController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => __('Reports')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Reports')]
        ];

        $menu = collect((new Menu())->items);

        $reports = $menu->where('slag', 'reports')->first();

        if (isset($reports['items'])) {
            $reports = $reports['items'];
            $reports = array_chunk($reports, 6);
        } else {
            $reports = [];
        }

        return view('admin.pages.reports.index', compact(
            'breadcrumbs', 'reports'
        ));
    }
}
