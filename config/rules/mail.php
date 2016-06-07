<?php
return [
  /** Admin Rules */
  [
    'allow',
    'roles' => ['admin'],
    'module' => 'mail',
    'controllers' => ['admin/template', 'admin/sendemail', 'default', 'partner']
  ],
];
