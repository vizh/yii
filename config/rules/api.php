<?php

return [
    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'api',
        'controllers' => ['admin/account'],
    ],
];
