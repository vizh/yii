<?php

return [
    [
        'allow',
        'users' => ['*'],
        'controllers' => ['default', 'recovery', 'fastauth'],
        'actions' => ['index'],
        'module' => 'main',
    ],
    [
        'allow',
        'users' => ['*'],
        'controllers' => ['error'],
        'module' => 'main',
    ],

    [
        'allow',
        'users' => ['*'],
        'controllers' => ['devcon', 'appday14'],
        'module' => 'main',
    ],

    [
        'allow',
        'users' => [528, 113001, 172852],
        'controllers' => ['info'],
        'actions' => ['appday14'],
        'module' => 'main',
    ],

    [
        'allow',
        'users' => [528, 113001, 172852, 1466, 59999, 122262],
        'controllers' => ['info'],
        'actions' => ['appdaycodes'],
        'module' => 'main',
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin', 'raec', 'booker', 'roommanager'],
        'module' => 'main',
        'controllers' => ['admin/default'],
    ],
    [
        'allow',
        'users' => [15648, 39948],
        'module' => 'main',
        'controllers' => ['admin/default'],
        'actions' => ['competence2'],
    ],
];
