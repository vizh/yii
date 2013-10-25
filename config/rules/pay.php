<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'pay',
    'controllers' => array('internal', 'cabinet', 'juridical', 'ajax', 'order', 'receipt')
  ),


  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'pay',
    'controllers' => array('admin/account')
  ),  
    
  array(
    'allow',
    'roles' => array('booker'),
    'module' => 'pay',
    'controllers' => array('admin/order')
  ),
);
