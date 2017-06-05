<?php

return [
    [
        'deny',
        'users' => ['?'],
        'module' => 'widget',
        'controllers' => ['link'],
        'actions' => ['cabinet']
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'widget',
        'controllers' => ['pay', 'link', 'speaker', 'test', 'auth']
    ],

    [
        'allow',
        'users' => ['@'],
        'module' => 'widget',
        'controllers' => ['paybuttons'],
        'actions' => ['index', 'juridical', 'success']
    ],

    [
        'allow',
        'users' => ['*'],
        'module' => 'widget',
        'controllers' => ['registration'],
        'actions' => ['index']
    ],

    [
        'allow',
        'users' => ['@'],
        'module' => 'widget',
        'controllers' => ['registration'],
        'actions' => ['participants', 'complete', 'pay', 'juridical']
    ]
];
