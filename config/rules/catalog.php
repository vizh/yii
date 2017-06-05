<?php

return [
    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'catalog',
        'controllers' => [
            'admin/company'
        ]
    ]
];
