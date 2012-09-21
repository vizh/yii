<?php

return array(
  array(
    'allow',
    'users' => array('?'),
    'controllers' => array('auth'),
    'actions' => array('login')
  ),
  array(
    'allow',
    'users' => array('?'),
    'controllers' => array('utility'),
    'actions' => array('ping')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'controllers' => array('event'),
    'actions' => array('users', 'register', 'unregister', 'changerole', 'roles', 'settings')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'controllers' => array('badge'),
    'actions' => array('list', 'create')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'controllers' => array('user'),
    'actions' => array('create', 'edit', 'search')
  ),
  array(
    'allow',
    'roles' => array('Operator'),
    'controllers' => array('product'),
    'actions' => array('paiditems', 'changepaid')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);