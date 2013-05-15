<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'controllers' => array('default', 'recovery', 'fastauth', 'test'),
    'actions' => array('index'),
    'module' => 'main'
  ),
  array(
    'allow',
    'users' => array('*'),
    'controllers' => array('error'),
    'module' => 'main'
  ),


  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin', 'raec', 'booker'),
    'module' => 'main',
    'controllers' => array('admin/default')
  ),
);