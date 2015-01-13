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
        'deny',
        'users' => ['*']
    ]
];