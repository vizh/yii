<?php
return [
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'raec',
        'controllers' => ['admin/brief']
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'raec',
        'controllers' => ['brief']
    ],
];