<?php
return array(
  array(
    'allow',
    'users' => array('?'),
    'controllers' => array('auth'),
    'actions' => array('index'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('user'),
    'actions' => array('statistics'),
    'module' => 'partner'
  ),
  array(
    'deny',
    'roles' => array('Partner'),
    'controllers' => array('user'),
    'actions' => array('statistics'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('main', 'order', 'user', 'coupon', 'userEdit', 'utility'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('orderitem'),
    'actions' => array('index', 'create'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('orderitem'),
    'actions' => array('activateajax', 'redirect'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('auth'),
    'actions' => array('logout'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('ruvents', 'internal'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('user'),
    'actions' => array('register'),
    'module' => 'partner'
  ),
  array(
    'allow',
    'roles' => array('Admin'),
    'controllers' => array('stat'),
    'module' => 'partner'
  ),
  array(
    'deny',
    'users' => array('*'),
    'module' => 'partner'
  ),
);