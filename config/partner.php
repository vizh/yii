<?php

return [
    'modules' => ['partner'],
    'components' => [
        'partner' => [
            'class' => '\partner\components\WebUser',
            'stateKeyPrefix' => 'partner',
            'loginUrl' => ['/partner/auth/index'],
            'identityCookie' => ['domain' => '.'.RUNETID_HOST],
            'authTimeout' => 12 * 60 * 60
        ],
        'partnerAuthManager' => [
            'class' => '\partner\components\PhpAuthManager',
            'defaultRoles' => ['guest']
        ]
    ]
];
