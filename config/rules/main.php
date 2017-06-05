<?php

return [
    [
        'allow',
        'users' => ['*'],
        'module' => 'main',
        'controllers' => ['default', 'recovery', 'fastauth'],
        'actions' => ['index']
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'main',
        'controllers' => ['error']
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'main',
        'controllers' => ['devcon', 'appday14']
    ],

    [
        'allow',
        'users' => [528, 113001, 172852],
        'module' => 'main',
        'controllers' => ['info'],
        'actions' => ['appday14']
    ],

    [
        'allow',
        'users' => [528, 113001, 172852, 1466, 59999, 122262],
        'module' => 'main',
        'controllers' => ['info'],
        'actions' => ['appdaycodes']
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin', 'raec', 'booker', 'roommanager'],
        'module' => 'main',
        'controllers' => ['admin/default']
    ],

    [
        'allow',
        'users' => [15648, 39948],
        'module' => 'main',
        'controllers' => ['admin/default'],
        'actions' => ['competence2']
    ],
];
