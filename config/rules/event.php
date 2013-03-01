<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'event',
    'controllers' => array('list', 'view')
  ),



  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'event',
    'controllers' => array('admin/default')
  ),
);