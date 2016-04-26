<?php
return array(
    array(
        'deny',
        'users' => array('?'),
        'module' => 'user',
        'controllers' => array('edit', 'setting', 'events')
    ),
    array(
        'deny',
        'users' => ['?'],
        'module' => 'user',
        'controllers' => ['ajax'],
        'actions' => ['phoneverify', 'verify']
    ),
    array(
        'allow',
        'users' => array('*'),
        'module' => 'user',
        'controllers' => array('ajax', 'view', 'edit', 'setting', 'logout', 'unsubscribe', 'events')
    ),

    /** Admin Rules */
    array(
        'allow',
        'roles' => array('admin'),
        'module' => 'user'
    ),
);