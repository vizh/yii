<?php

return array(
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('user'),
    'actions' => array('auth')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);