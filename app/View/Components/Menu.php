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
        $this->build();
    }

    private function build()
    {
        /** @var User $user */
        $user = \Auth::user();

        /** ----- Dashboard ----- */

        $this->items[] = [
            'name' => __('Dashboard'),
            'href' => route('home'),
            'image' => asset('assets/images/svg-icon/dashboard.svg'),
            'guard' => true,
        ];

        /** ----- Users ----- */

        $this->items[] = $user->hasRole('admin') ? [
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
                    'guard' => $user->hasRole('admin'),
                ]
            ]
        ] : [
            'name' => __('Users'),
            'image' => asset('assets/images/svg-icon/crm.svg'),
            'href' => route('users.index'),
            'guard' => true,
        ];

        /** ----- Distributors ----- */

        $this->items[] = [
            'name' => __('Distributors'),
            'href' => route('distributors.index'),
            'image' => asset('assets/images/svg-icon/maps.svg'),
            'guard' => $user->hasRole('admin'),
        ];

        /** ----- Companies ----- */

        $this->items[] = [
            'name' => __('Companies'),
            'href' => route('companies.index'),
            'image' => asset('assets/images/svg-icon/frontend.svg'),
            'guard' => $user->hasAnyRole(['admin', 'distributor']),
        ];

        /** ----- Statistics ----- */

        $this->items[] = [
            'name' => __('Statistics'),
            'href' => route('statistics.index'),
            'image' => asset('assets/images/svg-icon/charts.svg'),
            'guard' => true,
        ];

        /** ----- Reports ----- */

        $this->items[] = [
            'name' => __('Reports'),
            'href' => route('reports.index'),
            'image' => asset('assets/images/svg-icon/reports.svg'),
            'guard' => true,
        ];

        /** ----- Settings ----- */

        $this->items[] = [
            'name' => __('Settings'),
            'href' => route('settings.index'),
            'image' => asset('assets/images/svg-icon/settings.svg'),
            'guard' => $user->hasRole('admin'),
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
