<?php

return array(
  array(
    'allow',
    'users' => array('?'),
    'controllers' => array('auth'),
    'actions' => array('index')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('user'),
    'actions' => array('statistics')
  ),
  array(
    'deny',
    'roles' => array('Partner'),
    'controllers' => array('user'),
    'actions' => array('statistics')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('main', 'order', 'user', 'coupon', 'userEdit', 'utility'),
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('orderitem'),
    'actions' => array('index', 'create')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('orderitem'),
    'actions' => array('activateajax', 'redirect')
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('auth'),
    'actions' => array('logout')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('ruvents', 'internal')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('user'),
    'actions' => array('register')
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('stat')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);