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
    'roles' => array('Operator'),
    'controllers' => array('event'),
    'actions' => array('users', 'register', 'changerole', 'roles', 'settings')
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
    'actions' => array('create', 'edit')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);