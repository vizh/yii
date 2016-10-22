<?php

return [
    'modules' => ['api'],
    'components' => [
        'apiAuthManager' => [
            'class' => '\api\components\PhpAuthManager',
            'defaultRoles' => ['guest']
        ],
        'session' => [
            'autoStart' => false,
            'cookieMode' => 'none'
        ]
    ]
];
