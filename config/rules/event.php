<?php
return array(
    array(
        'deny',
        'users' => array('?'),
        'module' => 'event',
        'controllers' => array('exclusive/demo2013')
    ),
    array(
        'allow',
        'users' => array('*'),
        'module' => 'event',
        'controllers' => array('list', 'view', 'share', 'create', 'exclusive/demo2013', 'invite', 'ajax', 'ticket', 'fastregister')
    ),

    array(
        'allow',
        'users' => array('*'),
        'module' => 'event',
        'controllers' => array('exclusive/devcon16')
    ),


    /** Admin Rules */
    array(
        'allow',
        'roles' => array('admin'),
        'module' => 'event',
        'controllers' => array('admin/default', 'admin/edit', 'admin/list', 'admin/section', 'admin/oneuse', 'admin/mail', 'admin/fb', 'admin/demo')
    )
);