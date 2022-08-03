<?php

return [
    'account' => [
        'deactivation_in_days' => env('DEACTIVATION_IN_DAYS', false),
    ],
    'dateformat' => 'm/d/Y H:i:s',
    'ip_verify' => env('ADMIN_IP_VERIFY', false),
    'date' => [
        'format' => 'd/m/Y',
    ],
    'currency' => [
        'delimiter' => ' ',
        'format' => '{SYMBOL}{DELIMITER}{VALUE}',
    ],
    'number' => [
        'format' => [
            'decimals' => 2,
            'dec_point' => ',',
            'thousands_sep' => ' ',
        ]
    ],
    'datatable' => [
        'page_length' => 100,
        'length_menu' => [25, 50, 100]
    ],
    'menu' => [
        'main' => [
            'items' => [
                [
                    'name' => 'Dashboard',
                    'href' => 'home',
                    'image' => '/assets/images/svg-icon/dashboard.svg',
                ],
                [
                    'name' => 'Users',
                    'image' => '/assets/images/svg-icon/crm.svg',
                    'items' => [
                        [
                            'name' => 'Users',
                            'href' => 'users.index',
                            'image' => '/assets/images/svg-icon/customers.svg',
                        ],
                        [
                            'name' => 'Admins',
                            'href' => 'admins.index',
                            'image' => '/assets/images/svg-icon/customers.svg',
                        ]
                    ]
                ],
                [
                    'name' => 'Distributors',
                    'href' => 'distributors.index',
                    'image' => '/assets/images/svg-icon/maps.svg',
                ],
                [
                    'name' => 'Companies',
                    'href' => 'companies.index',
                    'image' => '/assets/images/svg-icon/frontend.svg',
                ],
                [
                    'name' => 'Statistics',
                    'href' => 'statistics.index',
                    'image' => '/assets/images/svg-icon/charts.svg',
                ],
                [
                    'name' => 'Reports',
                    'href' => 'reports.index',
                    'image' => '/assets/images/svg-icon/reports.svg',
                ],
                [
                    'name' => 'Settings',
                    'href' => 'settings.index',
                    'image' => '/assets/images/svg-icon/settings.svg',
                ],
            ]
        ]
    ],
    'templation' => [
        'title' => [
            'modify' => true,
            'prefix' => env('ADMIN_TITLE_PREFIX', 'HEI BackOffice'),
            'separator' => env('ADMIN_TITLE_SEPARATOR', '-')
        ],
        'footer' => [
            'enable' => false
        ],
        'search' => [
            'enable' => false
        ]
    ]
];
