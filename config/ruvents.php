<?php

return [
    'modules' => ['ruvents'],
    'components' => [
        'ruventsAuthManager' => [
            'class' => '\ruvents\components\PhpAuthManager',
            'defaultRoles' => ['guest'],
        ],
    ],
];
