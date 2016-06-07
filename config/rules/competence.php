<?php

return [
    [
        'allow',
        'users' => ['*'],
        'controllers' => ['main', 'event', 'digitalindex15', 'iidf'],
        'module' => 'competence',
    ],
    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'competence',
        'controllers' => ['admin/export', 'admin/export2', 'admin/export3', 'admin/export7', 'admin/main',
            'admin/runet'],
    ],
];
