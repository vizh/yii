<?php

return array(
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('user'),
  ),
  array(
    'allow',
    'users' => array('?', '*'),
    'module' => 'partner',
    'controllers' => array('auth'),
    'actions' => array('index')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('user'),
    'actions' => array('statistics')
  ),
  array(
    'deny',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('user'),
    'actions' => array('statistics')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('main', 'order', 'coupon', 'userEdit', 'utility', 'special'),
  ),
    [
        'allow',
        'users' => ['*'],
        'module' => 'partner',
        'controllers' => ['coupon'],
        'actions' => ['statistics']
    ],
    array(
        'allow',
        'roles' => array('Partner'),
        'module' => 'partner',
        'controllers' => array('user'),
        'actions' => array('index', 'edit', 'translate', 'invite')
    ),

  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('settings'),
    'actions' => array('roles')
  ),

    array(
        'allow',
        'roles' => array('PartnerVerified'),
        'module' => 'partner',
        'controllers' => array('user'),
        'actions' => array('export')
    ),


  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('settings'),
    'actions' => array('loyalty')
  ),

  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('user', 'user/import')
  ),

  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('orderitem'),
    'actions' => array('index', 'create', 'redirect')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('orderitem'),
    'actions' => array('activateajax')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('auth'),
    'actions' => array('logout')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('ruvents', 'internal')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('user'),
    'actions' => array('register')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'module' => 'partner',
    'controllers' => array('stat')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('program')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'module' => 'partner',
    'controllers' => array('competence')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);