<?php

namespace App\Http\Controllers;

class DashboardsController extends Controller
{
    public function __invoke()
    {
        $breadcrumbs = [
            ['title' => __('Dashboard')],
        ];

        $widgets = [
            ['name' => __('Statistics'), 'route' => route('statistics.index'), 'icon' => 'feather icon-pie-chart'],
            ['name' => __('Booking Users'), 'route' => route('booking-users.index'), 'icon' => 'feather icon-user'],
            ['name' => __('IP Filter'), 'route' => route('settings.ip-filter.index'), 'icon' => 'feather icon-file-text'],
        ];

        return view('admin.index', compact('breadcrumbs', 'widgets'));
    }
}
