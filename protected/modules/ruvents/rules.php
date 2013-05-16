<?php

return array(
  array(
    'allow',
    'users' => array('?'),
    'module' => 'ruvents',
    'controllers' => array('auth'),
    'actions' => array('login')
  ),
  array(
    'allow',
    'users' => array('?'),
    'module' => 'ruvents',
    'controllers' => array('utility'),
    'actions' => array('ping')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'module' => 'ruvents',
    'controllers' => array('event'),
    'actions' => array('users', 'register', 'unregister', 'roles', 'badge', 'updatedusers', 'info')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'module' => 'ruvents',
    'controllers' => array('badge'),
    'actions' => array('list', 'create')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'module' => 'ruvents',
    'controllers' => array('user'),
    'actions' => array('create', 'edit', 'search')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'module' => 'ruvents',
    'controllers' => array('product'),
    'actions' => array('paiditems', 'changepaid', 'paiditemslist')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'module' => 'ruvents',
    'controllers' => array('utility'),
    'actions' => array('changes')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);