<?php

return [
    [
        'allow',
        'users' => ['@'],
        'module' => 'pay',
        'controllers' => ['ajax'],
        'actions' => ['addorderitem', 'deleteorderitem', 'checkuserdata'],
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'pay',
        'controllers' => ['ajax'],
        'actions' => ['couponactivate', 'couponinfo', 'userdata', 'edituserdata'],
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'pay',
        'controllers' => ['cabinet', 'juridical', 'order', 'receipt', 'mailru'],
    ],

    /** Admin Rules */
    [
        'allow',
        'roles' => ['admin'],
        'module' => 'pay',
        'controllers' => [
            'admin/account', 'admin/import', 'admin/oneuse', 'admin/orderjuridicaltemplate', 'internal', 'admin/coupon'
        ],
    ],

    [
        'allow',
        'roles' => ['booker'],
        'module' => 'pay',
        'controllers' => ['admin/order'],
    ],

    [
        'allow',
        'roles' => ['roommanager', 'admin', 'booker'],
        'module' => 'pay',
        'controllers' => ['admin/booking'],
    ],

];
