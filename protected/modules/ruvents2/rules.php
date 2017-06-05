<?php

use ruvents2\components\Role;

return [
    [
        'allow',
        'users' => ['*'],
        'controllers' => ['utility'],
        'actions' => ['ping']
    ],
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['event']
    ],

    /** Participants */
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['participants'],
        'actions' => ['fields', 'list']
    ],
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['users'],
        'actions' => ['list']
    ],
    [
        'allow',
        'roles' => [Role::OPERATOR],
        'controllers' => ['participants'],
        'actions' => ['register', 'create', 'edit', 'delete']
    ],

    /** Badges */
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['badges'],
        'actions' => ['list']
    ],
    [
        'allow',
        'roles' => [Role::OPERATOR],
        'controllers' => ['badges'],
        'actions' => ['create']
    ],

    /** Positions */
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['positions'],
        'actions' => ['list']
    ],

    /** Products */
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['products'],
        'actions' => ['checks', 'check']
    ],

    /** Halls */
    [
        'allow',
        'roles' => [Role::SERVER],
        'controllers' => ['halls'],
        'actions' => ['checks', 'check']
    ],

    [
        'deny',
        'users' => ['*']
    ]
];