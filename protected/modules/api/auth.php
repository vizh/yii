<?php

return [
    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Без авторизации в рамках api',
        'bizRule' => null,
        'data' => null
    ],

    'base' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Базовый набор прав доступа',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'mobile' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Авторизация в качестве мобильного приложения',
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'partner' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Авторизация с партнерским доступом к api',
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'partner_woc' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Авторизация с партнерским доступом к api без доступа к персональным данным',
        'children' => [
            'base',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'own' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Авторизация с максимальным доступом к api',
        'children' => [
            'partner',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'sberbank' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Роль для сбербанка',
        'bizRule' => null,
        'data' => null
    ],

    'mblt' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Роль для MBLT',
        'bizRule' => null,
        'data' => null
    ],

    'microsoft' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Роль для проектов с MicroSoft',
        'bizRule' => null,
        'data' => null
    ]
];