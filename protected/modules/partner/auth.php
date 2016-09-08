<?php
return [
    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ],
    'PartnerLimited' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Partner without payments methods',
        'children' => [
            'guest',
        ],
        'bizRule' => null,
        'data' => null
    ],
    'Partner' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Partner',
        'children' => [
            'PartnerLimited',
        ],
        'bizRule' => null,
        'data' => null
    ],
    'PartnerVerified' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Partner',
        'children' => [
            'Partner'
        ],
        'bizRule' => null,
        'data' => null
    ],
    'PartnerExtended' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'PartnerExtended - account for multi-event access',
        'children' => [
            'Partner',
        ],
        'bizRule' => null,
        'data' => null
    ],
    'Admin' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => [
            'Partner'
        ],
        'bizRule' => null,
        'data' => null
    ],
    'AdminExtended' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'AdministratorExtended - account for multi-event access',
        'children' => [
            'Admin',
        ],
        'bizRule' => null,
        'data' => null
    ],
    'Statistics' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Statistics',
        'children' => [
            'guest'
        ],
        'bizRule' => null,
        'data' => null
    ],

    'moderator' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Модератор',
        'bizRule' => null,
        'data' => null,
        'children' => [
            'guest'
        ],
    ],
    'MassMedia' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Модератор СМИ',
        'children' => [
            'moderator'
        ],
        'bizRule' => '',
        'data' => [
            'roles' => [2,55,313,314,316]
        ]
    ],
    'Student' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Модератор студентов',
        'children' => [
            'moderator'
        ],
        'bizRule' => '',
        'data' => [
            'roles' => [307,315]
        ]
    ],
    'Program' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Модератор программы',
        'children' => [
            'moderator'
        ],
        'bizRule' => '',
        'data' => [
            'roles' => [180,333]
        ]
    ]
];