<?php
return array(
  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'api',
    'controllers' => array('admin/account')
  ),
);