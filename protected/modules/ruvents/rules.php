<?php

return array(
    [
        'allow',
        'users' =>  ['?'],
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
        'roles' => ['Mobile'],
        'controllers' => ['product'],
        'actions' => ['list', 'createproductget', 'productgetlist', 'fastpaiditems']
    ],


    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('utility'),
        'actions' => array('ping', 'operators')
    ),
    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('event'),
        'actions' => array('users', 'roles', 'parts', 'badge', 'updatedusers', 'info')
    ),
    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('badge'),
        'actions' => array('list')
    ),
    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('user'),
        'actions' => array('search')
    ),
    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('product'),
        'actions' => array('paiditems', 'paiditemslist')
    ),
    array(
        'allow',
        'roles' => array('Server'),
        'module' => 'ruvents',
        'controllers' => array('utility'),
        'actions' => array('changes')
    ),


    array(
        'allow',
        'roles' => array('Operator'),
        'module' => 'ruvents',
        'controllers' => array('event'),
        'actions' => array( 'register', 'unregister')
    ),
    array(
        'allow',
        'roles' => array('Operator'),
        'module' => 'ruvents',
        'controllers' => array('badge'),
        'actions' => array('create')
    ),
    [
        'allow',
        'roles' => ['Operator'],
        'module' => 'ruvents',
        'controllers' => ['user'],
        'actions' => ['create', 'edit']
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
);