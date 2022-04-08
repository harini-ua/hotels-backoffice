<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class Menu extends Component
{
    /** @var array */
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** @var User $user */
        $user = \Auth::user();

        $this->items = [
            [
                'name' => __('Dashboard'),
                'href' => route('home'),
                'image' => asset('assets/images/svg-icon/dashboard.svg'),
                'guard' => true,
            ],
            [
                'name' => __('Users'),
                'image' => asset('assets/images/svg-icon/crm.svg'),
                'guard' => true,
                'items' => [
                    [
                        'name' => __('Users'),
                        'href' => route('users.index'),
                        'image' => asset('assets/images/svg-icon/customers.svg'),
                        'guard' => true,
                    ],
                    [
                        'name' => __('Admins'),
                        'href' => route('admins.index'),
                        'image' => asset('assets/images/svg-icon/customers.svg'),
                        'guard' => true,
                    ]
                ]
            ],
            [
                'name' => __('Distributors'),
                'href' => route('distributors.index'),
                'image' => asset('assets/images/svg-icon/maps.svg'),
                'guard' => $user->hasRole('admin'),
            ],
            [
                'name' => __('Companies'),
                'href' => route('companies.index'),
                'image' => asset('assets/images/svg-icon/frontend.svg'),
                'guard' => true,
            ],
            [
                'name' => __('Statistics'),
                'href' => route('statistics.index'),
                'image' => asset('assets/images/svg-icon/charts.svg'),
                'guard' => true,
            ],
            [
                'name' => __('Reports'),
                'href' => route('reports.index'),
                'image' => asset('assets/images/svg-icon/reports.svg'),
                'guard' => true,
            ],
            [
                'name' => __('Settings'),
                'href' => route('settings.index'),
                'image' => asset('assets/images/svg-icon/settings.svg'),
                'guard' => true,
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu');
    }
}
