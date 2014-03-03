<?php
return array(
  array(
    'allow',
    'users' => ['*'],
    'module' => 'pay',
    'controllers' => array('internal', 'cabinet', 'juridical', 'ajax', 'order', 'receipt')
  ),


  /** Admin Rules */
  array(
    'allow',
    'roles' => ['admin'],
    'module' => 'pay',
    'controllers' => ['admin/account', 'admin/oneuse', 'admin/orderjuridicaltemplate']
  ),
    
  array(
    'allow',
    'roles' => ['booker'],
    'module' => 'pay',
    'controllers' => ['admin/order']
  ),

  array(
    'allow',
    'roles' => ['roommanager', 'admin'],
    'module' => 'pay',
    'controllers' => ['admin/booking']
  )


);
