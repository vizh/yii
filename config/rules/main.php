<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'controllers' => array('default'),
    'actions' => array('index'),
    'module' => 'main'
  ),


  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'main',
    'controllers' => array('admin/default')
  ),
);