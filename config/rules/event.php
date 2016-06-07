<?php

return [
    [
        'deny',
        'users' => ['?'],
        'module' => 'event',
        'controllers' => ['exclusive/demo2013'],
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'event',
        'controllers' => ['list', 'view', 'share', 'create', 'exclusive/demo2013', 'invite', 'ajax', 'ticket',
            'fastregister'],
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'event',
        'controllers' => ['exclusive/devcon16'],
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'event',
        'controllers' => ['admin/default', 'admin/edit', 'admin/list', 'admin/section', 'admin/oneuse', 'admin/mail',
            'admin/fb', 'admin/demo'],
    ],
];
