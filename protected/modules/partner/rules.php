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
    'roles' => array('Partner'),
    'controllers' => array('main', 'order', 'user', 'coupon', 'userEdit'),
  ),
  array(
    'allow',
    'roles' => array('Partner'),
    'controllers' => array('orderitem'),
    'actions' => array('index', 'create')
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
    'controllers' => array('ruvents')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);