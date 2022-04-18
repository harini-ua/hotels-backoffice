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
            'icon' => 'feather icon-grid',
            'guard' => true,
        ];

        /** ----- Users ----- */


        $this->items[] = [
            'name' => __('Users'),
            'icon' => 'feather icon-users',
            'guard' => true,
            'items' => [
                [
                    'name' => __('Admins'),
                    'href' => route('admins.index'),
                    'icon' => 'feather icon-user',
                    'guard' => $user->hasRole('admin'),
                ],
                [
                    'name' => __('Distributors'),
                    'href' => route('distributors.users.index'),
                    'icon' => 'feather icon-user',
                    'guard' => $user->hasRole('admin'),
                ],
                [
                    'name' => __('Bookings'),
                    'href' => route('users.index'),
                    'icon' => 'feather icon-user',
                    'guard' => true,
                ],
            ]
        ];

        /** ----- Distributors ----- */

        $this->items[] = [
            'name' => __('Distributors'),
            'href' => route('distributors.index'),
            'icon' => 'feather icon-truck',
            'guard' => $user->hasRole('admin'),
        ];

        $this->items[] = [
            'name' => __('Users'),
            'href' => route('distributors.users.index'),
            'icon' => 'feather icon-users',
            'guard' => $user->hasRole('distributor'),
        ];

        /** ----- Company Sites ----- */

        $this->items[] = [
            'name' => __('Company Sites'),
            'href' => route('companies.index'),
            'icon' => 'feather icon-shopping-bag',
            'guard' => $user->hasAnyRole(['admin', 'distributor']),
            'items' => [
                [
                    'name' => __('Themes'),
                    'href' => route('companies.themes.index'),
                    'icon' => 'feather icon-feather',
                    'guard' => $user->hasRole('admin'),
                ],
                [
                    'name' => __('Templates'),
                    'href' => route('companies.templates.index'),
                    'icon' => 'feather icon-feather',
                    'guard' => $user->hasRole('admin'),
                ]
            ]
        ];

        /** ----- Discounts ----- */

        $this->items[] = [
            'name' => __('Discounts'),
            'href' => route('discount-vouchers.index'),
            'icon' => 'feather icon-gift',
            'guard' => $user->hasAnyRole(['admin']),
        ];

        /** ----- Partners ----- */

        $this->items[] = [
            'name' => __('Partners'),
            'href' => route('partners.index'),
            'icon' => 'feather icon-briefcase',
            'guard' => $user->hasAnyRole(['admin']),
            'items' => [
                [
                    'name' => __('Products'),
                    'href' => route('partners.products.index'),
                    'icon' => 'feather icon-shopping-bag',
                    'guard' => $user->hasRole('admin'),
                ]
            ]
        ];

        /** ----- Statistics ----- */

        $this->items[] = [
            'name' => __('Statistics'),
            'href' => route('statistics.index'),
            'icon' => 'feather icon-pie-chart',
            'guard' => true,
        ];

        /** ----- Reports ----- */

        $this->items[] = [
            'name' => __('Reports'),
            'href' => route('reports.index'),
            'icon' => 'feather icon-file-text',
            'guard' => true,
        ];

        /** ----- Settings ----- */

        $this->items[] = [
            'name' => __('Settings'),
            'href' => route('settings.index'),
            'icon' => 'feather icon-settings',
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
