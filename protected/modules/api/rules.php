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
    'users' => array('*')
  ),
);