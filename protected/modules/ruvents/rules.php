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
    'actions' => array('users')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);