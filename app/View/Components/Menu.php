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
            'href' => route('home'),
            'image' => asset('assets/images/svg-icon/widgets.svg'),
            'guard' => true,
        ];

        /** ----- Users ----- */

        $this->items[] = [
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
        ];

        /** ----- Distributors ----- */

        $this->items[] = [
            'name' => __('Distributors'),
            'href' => route('distributors.index'),
            'image' => asset('assets/images/svg-icon/maps.svg'),
            'guard' => $user->hasRole('admin'),
            'items' => [
                [
                    'name' => __('Distributors Users'),
                    'href' => route('distributors.users.index'),
                    'image' => asset('assets/images/svg-icon/customers.svg'),
                    'guard' => $user->hasRole('admin'),
                ]
            ]
        ];

        $this->items[] = [
            'name' => __('Users'),
            'href' => route('distributors.users.index'),
            'image' => asset('assets/images/svg-icon/maps.svg'),
            'guard' => $user->hasRole('distributor')
        ];

        /** ----- Company Sites ----- */

        $this->items[] = [
            'name' => __('Company Sites'),
            'href' => route('companies.index'),
            'image' => asset('assets/images/svg-icon/frontend.svg'),
            'guard' => $user->hasAnyRole(['admin', 'distributor']),
            'items' => [
                [
                    'name' => __('Site Themes'),
                    'href' => route('companies.themes.index'),
                    'image' => asset('assets/images/svg-icon/ui-kits.svg'),
                    'guard' => $user->hasRole('admin')
                ],
                [
                    'name' => __('Site Templates'),
                    'href' => route('companies.templates.index'),
                    'image' => asset('assets/images/svg-icon/ui-kits.svg'),
                    'guard' => $user->hasRole('admin')
                ]
            ]
        ];

        /** ----- Discounts ----- */

        $this->items[] = [
            'name' => __('Discounts'),
            'href' => route('discount-vouchers.index'),
            'image' => asset('assets/images/svg-icon/backend.svg'),
            'guard' => $user->hasAnyRole(['admin']),
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
