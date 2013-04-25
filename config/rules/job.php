<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'job',
    'controllers' => array('default')
  ),
    
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'job',
    'controllers' => array('admin/edit', 'admin/list', 'admin/ajax')
  ),
);