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
        'deny',
        'users' => ['*']
    ]
];