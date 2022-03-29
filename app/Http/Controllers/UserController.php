<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $breadcrumbs = [
            ['title' => __('Users Dashboard')],
//            ['link' => route('home'), 'name' => __('Home')],
//            ['name' => __('Dashboard')]
        ];

        return view('admin.pages.users.dashboard', compact('breadcrumbs'));
    }
}
