<?php

use \ruvents2\components\Role;

return [
    [
        'allow',
        'users' =>  ['*'],
        'controllers' => ['utility'],
        'actions' => ['ping']
    ],
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['event']
    ],
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['participants'],
        'actions' => ['fields', 'list']
    ],
    [
        'allow',
        'roles' => [Role::OPERATOR],
        'controllers' => ['participants'],
        'actions' => ['ping']
    ],
    [
        'deny',
        'users' => ['*']
    ]
];