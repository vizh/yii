<?php

return array(
    array(
        'allow',
        'users' =>  array('?'),
        'module' => 'ruvents',
        'controllers' => array('utility'),
        'actions' => array('ping')
    ),

    [
        'allow',
        'roles' => ['Mobile'],
        'controllers' => ['visit']
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
    array(
        'allow',
        'roles' => array('Operator'),
        'module' => 'ruvents',
        'controllers' => array('user'),
        'actions' => array('create', 'edit')
    ),
    array(
        'allow',
        'roles' => array('Operator'),
        'module' => 'ruvents',
        'controllers' => array('product'),
        'actions' => array('changepaid')
    ),

    array(
        'deny',
        'users' => array('*')
    ),
);