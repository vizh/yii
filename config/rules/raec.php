<?php

return [
    [
        'allow',
        'roles' => ['raec'],
        'module' => 'raec',
        'controllers' => ['admin/brief', 'admin/commission']
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'raec',
        'controllers' => ['brief']
    ]
];
