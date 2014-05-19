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
    'deny',
    'users' => ['?'],
    'module' => 'widget',
    'controllers' => ['link'],
    'actions' => ['cabinet']
  ],
  [
    'allow',
    'users' => ['*'],
    'module' => 'widget',
    'controllers' => ['pay','link']
  ]
];