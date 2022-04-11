<?php

namespace App\View\Composers;

use Illuminate\View\View;

class MainAdminComposer
{
    public function compose(View $view)
    {
        return $view
            ->with('profile', \Auth::user())
        ;
    }
}
