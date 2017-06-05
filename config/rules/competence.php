<?php

return [
    [
        'allow',
        'users' => ['*'],
        'module' => 'competence',
        'controllers' => [
            'main',
            'event',
            'digitalindex15',
            'iidf'
        ]
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'competence',
        'controllers' => [
            'admin/export',
            'admin/export2',
            'admin/export3',
            'admin/export7',
            'admin/main',
            'admin/runet'
        ]
    ]
];
