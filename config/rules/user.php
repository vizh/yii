<?php
return array(
  array(
    'deny',
    'users' => array('?'),
    'module' => 'user',
    'controllers' => array('edit')
  ),
  array(
    'allow',
    'users' => array('*'),
    'module' => 'user'
  ),
);