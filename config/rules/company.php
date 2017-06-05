<?php

return [
    [
        'deny',
        'users' => ['?'],
        'module' => 'company',
        'controllers' => [
            'edit'
        ]
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'company',
        'controllers' => [
            'ajax',
            'list',
            'view',
            'edit'
        ]
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'company',
        'controllers' => [
            'admin/merge',
            'admin/main'
        ]
    ]
];
