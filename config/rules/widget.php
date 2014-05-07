<?php
return [
  [
    'deny',
    'users' => ['?'],
    'module' => 'widget',
    'controllers' => ['pay'],
    'actions' => ['cabinet','register']
  ],
  [
    'allow',
    'users' => ['*'],
    'module' => 'widget',
    'controllers' => ['pay']
  ]
];