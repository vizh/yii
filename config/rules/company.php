<?php
return array(
  array(
    'deny',
    'users' => array('?'),
    'module' => 'company',
    'controllers' => array('edit')
  ),
  array(
    'allow',
    'users' => array('*'),
    'module' => 'company',
    'controllers' => array('ajax','list','view', 'edit')
  ),
    
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'company',
    'controllers' => array('admin/moderator', 'admin/merge')
  ),
);