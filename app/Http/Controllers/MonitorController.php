<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MonitorController extends Controller
{
    public function index()
    {
        Artisan::call('server-monitor:run-checks');

        $hosts = Host::get();

        return view('admin.pages.monitor.index', [
            'hosts' => $hosts
        ]);
    }

    public function updatePageVisibility()
    {
        Cache::put('page_visibility', request('state'));

        return 'ok';
    }
}
