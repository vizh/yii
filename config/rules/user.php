<?php
return array(
  array(
    'deny',
    'users' => array('?'),
    'module' => 'user',
    'controllers' => array('edit','setting','logout')
  ),
  array(
    'allow',
    'users' => array('*'),
    'module' => 'user',
    'controllers' => array('ajax','view', 'edit','setting','logout')
  ),
    
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'user',
    'controllers' => array('admin/moderator')
  ),
);