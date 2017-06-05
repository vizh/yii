<?php

return [
    [
        'allow',
        'users' => ['*'],
        'module' => 'job',
        'controllers' => [
            'default'
        ]
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'job',
        'controllers' => [
            'admin/edit',
            'admin/list',
            'admin/ajax'
        ]
    ],
];
