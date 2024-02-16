<?php
return [
    'administrator' => [
        [
            'name' => 'MENU',
            'child' => [
                [
                    'name' => 'Dashboard',
                    'icon'   => '<i class="bx bx-home-circle"></i>',
                    'url'   => '/dashboard',
                    'child' => []
                ],
                [
                    'name' => 'Configuration',
                    'icon'   => '<i class="bx bx-cog"></i>',
                    'url'   => '/config',
                    'child' => []
                ]
            ],
        ],
        [
            'name' => 'SUBSCRIBERS',
            'child' => [
                [
                    'name' => 'Category Subscribers',
                    'icon'   => '<i class="bx bxs-group"></i>',
                    'url'   => '/category-subscribers',
                    'child' => []
                ],
                [
                    'name' => 'Subscriber Lists',
                    'icon'   => '<i class="bx bxs-group"></i>',
                    'url'   => '/subscribers',
                    'child' => []
                ],
                [
                    'name' => 'Import Subscribers',
                    'icon'   => '<i class="bx bxs-user-detail"></i>',
                    'url'   => '/import-subscribers',
                    'child' => []
                ],
                [
                    'name' => 'Export Subscribers',
                    'icon'   => '<i class="bx bx-group"></i>',
                    'url'   => '/export-subscribers',
                    'child' => []
                ],
            ],
        ],
        [
            'name' => 'CAMPAIGN',
            'child' => [
                [
                    'name' => 'New Campaign',
                    'icon' => '<i class="bx bx-list-plus"></i>',
                    'url'   => '/campaign/create'
                ],
                [
                    'name' => 'Campaign Lists',
                    'icon' => '<i class="bx bx-badge-check" ></i>',
                    'url'   => '/campaigns'
                ],
                [
                    'name' => 'Manage Templates',
                    'icon' => '<i class="bx bx-sort"></i>',
                    'url'   => '/campaign/manage-template'
                ],
            ]
        ],
        [
            'name' => 'REPORT',
            'child' => []
        ]
    ],
];
