<?php
return [
    [
        'allow',
        'roles' => ['raec'],
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