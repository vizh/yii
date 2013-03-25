<?php
return array(
  array(
    'allow',
    'users' => array('*'),
    'module' => 'pay',
    'controllers' => array('internal', 'cabinet', 'juridical', 'ajax', 'order')
  ),



  /** Admin Rules */
//  array(
//    'allow',
//    'roles' => array('admin'),
//    'module' => 'pay',
//    'controllers' => array('internal')
//  ),
);
