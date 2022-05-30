<?php

namespace App\View\Components;

use App\Enums\UserRole;
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
            'slag' => 'users',
            'href' => route('users.index'),
            'guard' => true,
            'items' => [
                [
                    'name' => __('Admin Users'),
                    'href' => route('admins.index'),
                    'icon' => 'feather icon-user',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Distributor Users'),
                    'href' => route('distributors.users.index'),
                    'icon' => 'feather icon-user',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Booking Users'),
                    'href' => route('booking-users.index'),
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
            'guard' => $user->hasRole(UserRole::ADMIN),
        ];

        $this->items[] = [
            'name' => __('Users'),
            'href' => route('distributors.users.index'),
            'icon' => 'feather icon-users',
            'guard' => $user->hasRole(UserRole::DISTRIBUTOR),
        ];

        /** ----- Company Sites ----- */

        $this->items[] = [
            'name' => __('Company Sites'),
            'href' => route('companies.index'),
            'icon' => 'feather icon-shopping-bag',
            'guard' => $user->hasAnyRole([UserRole::ADMIN, UserRole::DISTRIBUTOR]),
            'items' => [
                [
                    'name' => __('Themes'),
                    'href' => route('companies.themes.index'),
                    'icon' => 'feather icon-feather',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Templates'),
                    'href' => route('companies.templates.index'),
                    'icon' => 'feather icon-feather',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ]
            ]
        ];

        /** ----- Discounts ----- */

        $this->items[] = [
            'name' => __('Discounts'),
            'href' => route('discount-vouchers.index'),
            'icon' => 'feather icon-gift',
            'guard' => $user->hasAnyRole([UserRole::ADMIN]),
        ];

        /** ----- Partners ----- */

        $this->items[] = [
            'name' => __('Partners'),
            'href' => route('partners.index'),
            'icon' => 'feather icon-briefcase',
            'guard' => $user->hasAnyRole([UserRole::ADMIN]),
            'items' => [
                [
                    'name' => __('Products'),
                    'href' => route('partners.products.index'),
                    'icon' => 'feather icon-shopping-bag',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ]
            ]
        ];

        /** ----- Newsletters ----- */

        $this->items[] = [
            'name' => __('Newsletters'),
            'href' => route('newsletters.create'),
            'icon' => 'feather icon-send',
            'guard' => $user->hasAnyRole([UserRole::ADMIN, UserRole::DISTRIBUTOR, UserRole::EMPLOYEE]),
        ];

        /** ----- Statistics ----- */

        $this->items[] = [
            'name' => __('Statistics'),
            'slag' => 'statistics',
            'href' => route('statistics.index'),
            'icon' => 'feather icon-pie-chart',
            'guard' => true,
            'items' => [
                [
                    'name' => __('Overall BookingSeeder'),
                    'href' => route('statistics.overall-bookings.index'),
                    'icon' => 'feather icon-briefcase',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Searching By Period'),
                    'href' => route('statistics.searching-period.index'),
                    'icon' => 'feather icon-calendar',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
            ]
        ];

        /** ----- Reports ----- */

        $this->items[] = [
            'name' => __('Reports'),
            'slag' => 'reports',
            'href' => route('reports.index'),
            'icon' => 'feather icon-file-text',
            'guard' => $user->hasRole(UserRole::ADMIN),
            'items' => [
                [
                    'name' => __('Hotels Summary'),
                    'href' => route('reports.hotels.summary.index'),
                    'icon' => 'feather icon-home',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
            ]
        ];

        /** ----- Settings ----- */

        $this->items[] = [
            'name' => __('Settings'),
            'slag' => 'settings',
            'href' => route('settings.index'),
            'icon' => 'feather icon-settings',
            'guard' => $user->hasRole(UserRole::ADMIN),
            'items' => [
                [
                    'name' => __('Providers'),
                    'href' => route('providers.index'),
                    'icon' => 'feather icon-package',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Countries'),
                    'href' => route('countries.index'),
                    'icon' => 'feather icon-flag',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Cities'),
                    'href' => route('cities.index'),
                    'icon' => 'feather icon-globe',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('IP Filter'),
                    'href' => route('settings.ip-filter.index'),
                    'icon' => 'feather icon-filter',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
//                [
//                    'name' => __('Commissions'),
//                    'href' => route('settings.commissions.edit'),
//                    'icon' => 'feather icon-percent',
//                    'guard' => $user->hasRole(UserRole::ADMIN),
//                ],
                [
                    'name' => __('Popular Hotels'),
                    'href' => route('settings.popular-hotels.index'),
                    'icon' => 'feather icon-star',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Special Offer Hotels'),
                    'href' => route('settings.special-offer-hotels.index'),
                    'icon' => 'feather icon-check-square',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Recommended Hotels'),
                    'href' => route('settings.recommended-hotels.index'),
                    'icon' => 'feather icon-award',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Hotel Badges'),
                    'href' => route('settings.hotel-badges.index'),
                    'icon' => 'feather icon-bookmark',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Default Content'),
                    'href' => route('settings.default-content.edit'),
                    'icon' => 'feather icon-file-plus',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ],
                [
                    'name' => __('Promo Messages'),
                    'href' => route('promo-messages.index'),
                    'icon' => 'feather icon-bell',
                    'guard' => $user->hasRole(UserRole::ADMIN),
                ]
            ]
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
