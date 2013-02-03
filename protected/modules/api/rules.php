<?php

return array(
  array(
    'allow',
    'roles' => array('Mobile'),
    'controllers' => array('user'),
    'actions' => array('auth')
  ),
  array(
    'deny',
    'users' => array('*')
  ),
);