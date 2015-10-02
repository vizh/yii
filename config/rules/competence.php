<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'controllers' => array('main', 'event', 'digitalindex15'),
    'module' => 'competence'
  ),
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'competence',
    'controllers' => array('admin/export', 'admin/export2', 'admin/export3', 'admin/export7', 'admin/main', 'admin/runet')
  ),
);