<?php

return [
    [
        'deny',
        'users' => ['?'],
        'module' => 'user',
        'controllers' => ['edit', 'setting', 'events'],
    ],
    [
        'deny',
        'users' => ['?'],
        'module' => 'user',
        'controllers' => ['ajax'],
        'actions' => ['phoneverify', 'verify'],
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'user',
        'controllers' => ['ajax', 'view', 'edit', 'setting', 'logout', 'unsubscribe', 'events'],
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'user',
    ],
];
