<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'catalog',
    'controllers' => array()
  ),
    
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'catalog',
    'controllers' => array('admin/company')
  ),
);