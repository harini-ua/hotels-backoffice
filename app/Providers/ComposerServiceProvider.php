<?php

namespace App\Providers;

use App\View\Composers\MainAdminComposer;
use App\View\Composers\NotFoundComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.*', MainAdminComposer::class);
    }
}
