<?php

return array(
    [
        'allow',
        'users' => ['@'],
        'module' => 'partner',
        'controllers' => ['main'],
        'actions' => ['home']
    ],
    [
        'allow',
        'module' => 'partner',
        'controllers' => ['auth'],
        'actions' => ['logout']
    ],
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
    [
        'allow',
        'users' => ['@'],
        'module' => 'partner',
        'controllers' => ['ajax'],
        'actions' => ['users']
    ],
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
        'roles' => ['Partner'],
        'module' => 'partner',
        'controllers' => ['connect']
    ],
    [
        'allow',
        'roles' => ['Eurasia'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['index', 'edit', 'find', 'translate', 'invite', 'competence', 'viewdatafile', 'data']
    ],

    [
        'deny',
        'roles' => ['Statistics'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['import']
    ],
    [
        'allow',
        'roles' => ['Statistics'],
        'module' => 'partner',
        'controllers' => ['user', 'main'],
    ],

    [
        'allow',
        'roles' => ['moderator'],
        'module' => 'partner',
        'controllers' => ['auth'],
    ],
    [
        'allow',
        'roles' => ['moderator'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['index', 'edit', 'find', 'translate', 'invite', 'competence', 'viewdatafile', 'data']
    ],
    [
        'allow',
        'roles' => ['moderator'],
        'module' => 'partner',
        'controllers' => ['main'],
        'actions' => ['index']
    ],
    [
        'allow',
        'roles' => ['Approve'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['export']
    ],
    [
        'allow',
        'roles' => ['Approve'],
        'module' => 'partner',
        'controllers' => ['coupon'],
    ],
    [
        'allow',
        'roles' => ['Program'],
        'module' => 'partner',
        'controllers' => ['program']
    ],
    [
        'allow',
        'roles' => ['Program', 'Approve'],
        'module' => 'partner',
        'controllers' => ['coupon', 'generate']
    ],


    array(
        'deny',
        'users' => array('*')
    )
);