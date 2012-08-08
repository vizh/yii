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
    'controllers' => array('main', 'order'),
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);