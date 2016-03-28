<?php

return [
    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ],

    'Server' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Server',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'Mobile' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Mobile',
        'children' => ['guest'],
        'bizRule' => null,
        'data' => null
    ],

    'Operator' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Operator',
        'children' => [
            'Server',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'Admin' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => [
            'Operator',
        ],
        'bizRule' => null,
        'data' => null
    ],
];