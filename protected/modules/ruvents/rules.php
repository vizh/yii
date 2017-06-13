<?php

return [
    [
        'allow',
        'users' => ['?'],
        'module' => 'ruvents',
        'controllers' => ['utility'],
        'actions' => ['ping']
    ],

    [
        'allow',
        'roles' => ['Mobile'],
        'controllers' => ['visit']
    ],

    [
        'allow',
        'roles' => ['Server'],
        'controllers' => ['visit'],
        'actions' => ['list'],
    ],

    [
        'allow',
        'roles' => ['Mobile'],
        'controllers' => ['product'],
        'actions' => ['list', 'createproductget', 'productgetlist', 'fastpaiditems']
    ],

    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['utility'],
        'actions' => ['ping', 'operators']
    ],
    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['event'],
        'actions' => ['roles', 'parts', 'badge', 'updatedusers', 'info']
    ],
    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['badge'],
        'actions' => ['create', 'list']
    ],
    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['user'],
        'actions' => ['search', 'visit', 'photo', 'editAttribute']
    ],
    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['product'],
        'actions' => ['paiditems', 'paiditemslist']
    ],
    [
        'allow',
        'roles' => ['Server'],
        'module' => 'ruvents',
        'controllers' => ['utility'],
        'actions' => ['changes']
    ],

    [
        'allow',
        'roles' => ['Operator'],
        'module' => 'ruvents',
        'controllers' => ['event'],
        'actions' => ['register', 'unregister']
    ],
    [
        'allow',
        'roles' => ['Operator'],
        'module' => 'ruvents',
        'controllers' => ['badge'],
        'actions' => ['create']
    ],
    [
        'allow',
        'roles' => ['Operator'],
        'module' => 'ruvents',
        'controllers' => ['user'],
        'actions' => ['create', 'edit', 'editAttribute']
    ],
    [
        'allow',
        'roles' => ['Operator'],
        'module' => 'ruvents',
        'controllers' => ['product'],
        'actions' => ['changepaid']
    ],

    [
        'deny',
        'users' => ['*']
    ],
];