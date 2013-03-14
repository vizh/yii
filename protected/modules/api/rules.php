<?php

return array(
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('user'),
    'actions' => array('auth', 'search', 'create', 'get')
  ),
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('event'),
    'actions' => array('register')
  ),
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('pay')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('event'),
    'actions' => array('roles', 'register')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('pay')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);