<?php
return array(


  /** Admin Rules */
  array(
    'allow',
    'roles' => array('raec', 'admin'),
    'module' => 'commission',
    'controllers' => array('admin/edit', 'admin/list', 'admin/user')
  ),
);
