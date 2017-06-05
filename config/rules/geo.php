<?php

return [
    [
        'allow',
        'users' => ['*'],
        'module' => 'geo'
    ],

    [
        'deny',
        'users' => ['*'],
        'module' => 'geo',
        'controllers' => [
            'admin/ajax'
        ]
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'contact',
        'controllers' => [
            'admin/ajax'
        ]
    ]
];
