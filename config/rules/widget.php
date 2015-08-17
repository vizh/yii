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
        'controllers' => ['pay', 'link', 'speaker', 'test', 'register', 'auth']
    ],
    [
        'allow',
        'users' => ['@'],
        'module' => 'widget',
        'controllers' => ['paybuttons'],
        'actions' => ['index', 'juridical', 'success']
    ]
];