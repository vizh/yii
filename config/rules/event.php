<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'event',
    'controllers' => array('list', 'view', 'share')
  ),



  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'event',
    'controllers' => array('admin/default', 'admin/edit', 'admin/list', 'admin/section')
  ),
);