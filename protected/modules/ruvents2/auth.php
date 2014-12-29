<?php

use ruvents2\components\Role;

return [
    Role::GUEST => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к api без авторизации',
        'bizRule' => null,
        'data' => null
    ],
    Role::SERVER => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к api с авторизацией на уровне сервера',
        'children' => [Role::GUEST],
        'bizRule' => null,
        'data' => null
    ],
    Role::OPERATOR => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к api с авторизацией на уровне сервера и фиксированным оператором',
        'children' => [Role::SERVER],
        'bizRule' => null,
        'data' => null
    ]
];