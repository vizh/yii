<?php

use api\models\Account;

$apiAccountRoleLabels = Account::getRoleLabels();

return [
    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Без авторизации в рамках api',
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_BASE => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Базовый уровень доступа',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_OFFLINE => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_OFFLINE],
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_MOBILE => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_MOBILE],
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_PARTNER => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_PARTNER],
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_PARTNER_WOC => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_PARTNER_WOC],
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_PROFIT => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_PROFIT],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_OWN => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_OWN],
        'children' => [
            Account::ROLE_PARTNER,
        ],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_MBLT => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_MBLT],
        'bizRule' => null,
        'data' => null
    ],

    Account::ROLE_MICROSOFT => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => $apiAccountRoleLabels[Account::ROLE_MICROSOFT],
        'bizRule' => null,
        'data' => null
    ]
];