<?php
return array(
  [
    'allow',
    'users' => ['*'],
    'module' => 'mail'
  ],

  /** Admin Rules */
  [
    'allow',
    'roles' => ['admin'],
    'module' => 'mail',
    'controllers' => ['admin/filter']
  ],
);