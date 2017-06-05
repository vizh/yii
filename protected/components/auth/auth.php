<?php

return [
    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Без авторизации',
        'bizRule' => null,
        'data' => null
    ],

    'admin' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Админский доступ',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'raec' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'РАЭК доступ',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'booker' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Бухгалтерский доступ',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'roommanager' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администрирование номероного фонда',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],
];