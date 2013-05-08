<?php
return array(


  /** Admin Rules */
  array(
    'allow',
    'roles' => array('admin'),
    'module' => 'commission',
    'controllers' => array('admin/edit', 'admin/list', 'admin/user')
  ),
);
