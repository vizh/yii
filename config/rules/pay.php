<?php
return array(
  array(
    'allow',
    'users' => ['*'],
    'module' => 'pay',
    'controllers' => ['cabinet', 'juridical', 'ajax', 'order', 'receipt', 'mailru']
  ),


  /** Admin Rules */
  array(
    'allow',
    'roles' => ['admin'],
    'module' => 'pay',
    'controllers' => ['admin/account', 'admin/oneuse', 'admin/orderjuridicaltemplate', 'internal', 'admin/coupon']
  ),
    
  array(
    'allow',
    'roles' => ['booker'],
    'module' => 'pay',
    'controllers' => ['admin/order']
  ),

  array(
    'allow',
    'roles' => ['roommanager', 'admin', 'booker'],
    'module' => 'pay',
    'controllers' => ['admin/booking']
  )


);
