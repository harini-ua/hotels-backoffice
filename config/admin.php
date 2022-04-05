<?php

return [
    'dateformat' => 'm/d/Y H:i:s',
    'ip' => [
        'verify' => env('ADMIN_IP_VERIFY', false),
        'allowed' => [
            '90.149.165.44',
            '182.76.203.185',
            '178.232.22.240',
            '159.224.44.252',
            '89.10.228.105',
            '77.120.129.3',
            '85.19.65.140',
            '178.150.163.65',
            '84.212.26.26',
            '109.87.98.21',
            '93.76.191.103',
            '195.140.224.61',
            '77.122.70.5',
            '128.124.244.82',
        ],
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
            'prefix' => env('ADMIN_TITLE_PREFIX', 'Admin'),
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
