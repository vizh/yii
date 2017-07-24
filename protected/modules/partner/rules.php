<?php

return [
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
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['user']
    ],
    [
        'allow',
        'users' => ['?', '*'],
        'module' => 'partner',
        'controllers' => ['auth'],
        'actions' => ['index']
    ],
    [
        'allow',
        'users' => ['@'],
        'module' => 'partner',
        'controllers' => ['ajax'],
        'actions' => ['users']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['statistics']
    ],
    [
        'deny',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['statistics']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['main', 'coupon', 'userEdit', 'utility', 'special']
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
        'controllers' => ['ajax']
    ],
    [
        'allow',
        'roles' => ['Partner'],
        'module' => 'partner',
        'controllers' => ['order'],
        'actions' => ['edit', 'activate', 'delete']
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
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['paperless/event', 'paperless/material']
    ],
    [
        'allow',
        'roles' => ['AdminExtended'],
        'module' => 'partner',
        'controllers' => ['paperless']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['settings'],
        'actions' => ['loyalty', 'roles', 'api', 'definitions', 'counter']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['user', 'user/import']
    ],
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
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['orderitem'],
        'actions' => ['activateajax']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['auth'],
        'actions' => ['logout']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['ruvents', 'internal']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['user'],
        'actions' => ['register']
    ],
    [
        'allow',
        'roles' => ['Admin'],
        'module' => 'partner',
        'controllers' => ['stat']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['program']
    ],
    [
        'allow',
        'roles' => ['PartnerLimited'],
        'module' => 'partner',
        'controllers' => ['competence']
    ],
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
        'controllers' => ['user', 'main']
    ],
    [
        'allow',
        'roles' => ['moderator'],
        'module' => 'partner',
        'controllers' => ['auth']
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
        'controllers' => ['coupon']
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
    [
        'allow',
        'roles' => ['Meeting'],
        'module' => 'partner',
        'controllers' => ['connect']
    ],
    [
        'deny',
        'users' => ['*']
    ]
];