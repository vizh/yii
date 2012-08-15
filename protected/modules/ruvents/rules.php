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
    'actions' => array('users', 'register', 'changerole')
  ),
  array(
      'allow',
      'roles' => array('Operator'),
      'controllers' => array('badge'),
      'actions' => array('list', 'create')
    ),
  array(
    'deny',
    'users' => array('*')
  ),
);