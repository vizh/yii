<?php

return [
    /** Admin Rules */
    [
        'allow',
        'roles' => ['raec', 'admin'],
        'module' => 'commission',
        'controllers' => [
            'admin/edit',
            'admin/list',
            'admin/user',
            'admin/export'
        ]
    ],
];
