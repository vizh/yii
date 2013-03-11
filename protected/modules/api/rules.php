<?php

return array(
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('user'),
    'actions' => array('auth', 'search', 'create')
  ),
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('event'),
    'actions' => array('register')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('event'),
    'actions' => array('roles', 'register')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);