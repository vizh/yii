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
    'roles' => array('admin', 'raec', 'booker'),
    'module' => 'competence',
    'controllers' => array('admin/export')
  ),

);