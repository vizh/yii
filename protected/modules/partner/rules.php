<?php

return array(
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('user'),
    ),
    array(
        'allow',
        'users' => array('?', '*'),
        'module' => 'partner',
        'controllers' => array('auth'),
        'actions' => array('index')
    ),
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('user'),
        'actions' => array('statistics')
    ),
    array(
        'deny',
        'roles' => array('PartnerLimited'),
        'module' => 'partner',
        'controllers' => array('user'),
        'actions' => array('statistics')
    ),
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['main', 'coupon', 'userEdit', 'utility', 'special'],
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['order'],
        'actions' => ['index', 'view']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['ajax'],
    ],
    [
        'allow',
        'roles' => ['Partner'],
        'module' => 'partner',
        'controllers' => ['order'],
        'actions' => ['edit','activate','delete']
    ],
    [
        'allow',
        'users' => ['*'],
        'module' => 'partner',
        'controllers' => ['coupon'],
        'actions' => ['statistics']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['index', 'edit', 'translate', 'invite', 'competence', 'viewdatafile', 'data']
    ],
    [
        'allow',
        'roles' => ['PartnerVerified'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['export', 'exportdownload']
    ],


    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('settings'),
        'actions' => array('loyalty', 'roles', 'api', 'definitions')
    ),

    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('user', 'user/import')
    ),
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['orderitem'],
        'actions' => ['index']
    ],
    [
        'allow',
        'roles' => ['Partner'],
        'module' => 'partner',
        'controllers' => ['orderitem'],
        'actions' => ['create', 'redirect', 'refund']
    ],
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('orderitem'),
        'actions' => array('activateajax')
    ),
    array(
        'allow',
        'roles' => array('PartnerLimited'),
        'module' => 'partner',
        'controllers' => array('auth'),
        'actions' => array('logout')
    ),
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('ruvents', 'internal')
    ),
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('user'),
        'actions' => array('register')
    ),
    array(
        'allow',
        'roles' => array('Admin'),
        'module' => 'partner',
        'controllers' => array('stat')
    ),
    array(
        'allow',
        'roles' => array('PartnerLimited'),
        'module' => 'partner',
        'controllers' => array('program')
    ),
    array(
        'allow',
        'roles' => array('PartnerLimited'),
        'module' => 'partner',
        'controllers' => array('competence')
    ),
    [
        'allow',
        'roles' => ['Statistics'],
        'module' => 'partner',
        'controllers' => ['main'],
    ],
    array(
        'deny',
        'users' => array('*')
    )
);