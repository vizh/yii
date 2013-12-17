<?php
return array(
  /** Admin Rules */
  [
    'allow',
    'roles' => ['admin'],
    'module' => 'mail',
    'controllers' => ['admin/template', 'default', 'partner']
  ],
);