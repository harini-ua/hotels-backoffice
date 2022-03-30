<?php

namespace App\View\Composers;

use Illuminate\View\View;

class MainAdminComposer
{
    public function compose(View $view)
    {
        return $view
            ->with('user', \Auth::user())
            ->with('mainMenuItems', config('admin.menu.main.items'));
    }
}
