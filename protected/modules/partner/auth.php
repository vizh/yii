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
];