<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'pay',
    'controllers' => array('internal', 'cabinet', 'juridical', 'ajax', 'order')
  ),



  /** Admin Rules */
  array(
    'allow',
    'roles' => array('booker'),
    'module' => 'pay',
    'controllers' => array('admin/order')
  ),
);
