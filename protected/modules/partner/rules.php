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
    'controllers' => array('main', 'order', 'user'),
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);