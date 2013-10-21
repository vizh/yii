<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'controllers' => array('main'),
    'module' => 'competence'
  ),
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'competence',
    'controllers' => array('admin/export', 'admin/export2', 'admin/main')
  ),
);