<?php

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

define('SCHEMA', YII_DEBUG ? 'http' : 'https');
return [
    /** PHDays2014 */
    SCHEMA . '://phdays2014.'.RUNETID_HOST.'/' => ['event/view/index/', 'defaultParams' => ['idName' => 'phdays2014']],
    SCHEMA . '://phdays2014.'.RUNETID_HOST.'/register/' => ['pay/cabinet/register/', 'defaultParams' => ['eventIdName' => 'phdays2014']],
    SCHEMA . '://phdays2014.'.RUNETID_HOST.'/pay/' => ['pay/cabinet/index/', 'defaultParams' => ['eventIdName' => 'phdays2014']],
    SCHEMA . '://phdays2014.'.RUNETID_HOST.'/create/' => ['pay/juridical/create/', 'defaultParams' => ['eventIdName' => 'phdays2014']],

    /** Mblt 2013 */
    SCHEMA . '://mblt2013.'.RUNETID_HOST.'/' => ['event/view/index/', 'defaultParams' => ['idName' => 'mblt2013']],
    SCHEMA . '://mblt2013.'.RUNETID_HOST.'/register/' => ['pay/cabinet/register/', 'defaultParams' => ['eventIdName' => 'mblt2013']],
    SCHEMA . '://mblt2013.'.RUNETID_HOST.'/pay/' => ['pay/cabinet/index/', 'defaultParams' => ['eventIdName' => 'mblt2013']],
    SCHEMA . '://mblt2013.'.RUNETID_HOST.'/create/' => ['pay/juridical/create/', 'defaultParams' => ['eventIdName' => 'mblt2013']],

    /** Demo 2013 */
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/' => ['event/view/index/', 'defaultParams' => ['idName' => 'demo2013']],
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/register/' => ['pay/cabinet/register/', 'defaultParams' => ['eventIdName' => 'demo2013']],
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/pay/' => ['pay/cabinet/index/', 'defaultParams' => ['eventIdName' => 'demo2013']],
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/create/' => ['pay/juridical/create/', 'defaultParams' => ['eventIdName' => 'demo2013']],
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/pay/alley/' => ['event/exclusive/demo2013/alley/', 'defaultParams' => ['eventIdName' => 'demo2013']],
    SCHEMA . '://demo2013.'.RUNETID_HOST.'/exibitionlinks/' => ['event/exclusive/demo2013/exibitionlinks/', 'defaultParams' => ['eventIdName' => 'demo2013']],

    /** PhDays 2013 */
    SCHEMA . '://phdays2013.'.RUNETID_HOST.'/' => ['event/view/index/', 'defaultParams' => ['idName' => 'phdays2013']],
    SCHEMA . '://phdays2013.'.RUNETID_HOST.'/register/' => ['pay/cabinet/register/', 'defaultParams' => ['eventIdName' => 'phdays2013']],
    SCHEMA . '://phdays2013.'.RUNETID_HOST.'/pay/' => ['pay/cabinet/index/', 'defaultParams' => ['eventIdName' => 'phdays2013']],
    SCHEMA . '://phdays2013.'.RUNETID_HOST.'/create/' => ['pay/juridical/create/', 'defaultParams' => ['eventIdName' => 'phdays2013']],

    /** TC 2013 */
    SCHEMA . '://tc2013.'.RUNETID_HOST.'/' => ['event/view/index/', 'defaultParams' => ['idName' => 'tc2013']],
    SCHEMA . '://tc2013.'.RUNETID_HOST.'/register/' => ['pay/cabinet/register/', 'defaultParams' => ['eventIdName' => 'tc2013']],
    SCHEMA . '://tc2013.'.RUNETID_HOST.'/pay/' => ['pay/cabinet/index/', 'defaultParams' => ['eventIdName' => 'tc2013']],
    SCHEMA . '://tc2013.'.RUNETID_HOST.'/create/' => ['pay/juridical/create/', 'defaultParams' => ['eventIdName' => 'tc2013']],

    /** iResearch 2014 */
    SCHEMA . '://'.RUNETID_HOST.'/iresearch2014/' => ['competence/main/index/', 'defaultParams' => ['id' => 8]],
    SCHEMA . '://'.RUNETID_HOST.'/iresearch2014/process/' => ['competence/main/process/', 'defaultParams' => ['id' => 8]],
    SCHEMA . '://'.RUNETID_HOST.'/iresearch2014/end' => ['competence/main/end/', 'defaultParams' => ['id' => 8]],
    SCHEMA . '://'.RUNETID_HOST.'/iresearch2014/done' => ['competence/main/done/', 'defaultParams' => ['id' => 8]],

    /** Partner Module Rules */
    SCHEMA . '://partner.'. RUNETID_HOST.'/' => 'partner/main/index',
    SCHEMA . '://partner.'. RUNETID_HOST.'/auth/' => 'partner/auth/index',
    SCHEMA . '://partner.'. RUNETID_HOST.'/user/edit/<action:\w+>' => 'partner/userEdit/<action>',
    SCHEMA . '://partner.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'partner/<controller>/<action>',

    /** Ruvents Module Rules */
    'http://ruvents.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents/<controller>/<action>',

    /** Event Interview Rules */
    SCHEMA . '://' . RUNETID_HOST . '/vote/edu' => ['competence/main/index/', 'defaultParams' => ['id' => 39]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/edu/process' => ['competence/main/process/', 'defaultParams' => ['id' => 39]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/edu/done' => ['competence/main/done', 'defaultParams' => ['id' => 39]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/edu/after' => ['competence/main/after', 'defaultParams' => ['id' => 39]],

    /** Mail.Ru Proftest  2016 */
    SCHEMA . '://' . RUNETID_HOST . '/proftest2016/' => ['competence/main/index/', 'defaultParams' => ['id' => 46]],
    SCHEMA . '://' . RUNETID_HOST . '/proftest2016/process/' => ['competence/main/process/', 'defaultParams' => ['id' => 46]],
    SCHEMA . '://' . RUNETID_HOST . '/proftest2016/end' => ['competence/main/end/', 'defaultParams' => ['id' => 46]],
    SCHEMA . '://' . RUNETID_HOST . '/proftest2016/done' => ['competence/main/done/', 'defaultParams' => ['id' => 46]],

    SCHEMA . '://' . RUNETID_HOST . '/vote/iri' => ['competence/main/index/', 'defaultParams' => ['id' => 41]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/iri/process' => ['competence/main/process/', 'defaultParams' => ['id' => 41]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/iri/done' => ['competence/main/done', 'defaultParams' => ['id' => 41]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/iri/after' => ['competence/main/after', 'defaultParams' => ['id' => 41]],

    SCHEMA . '://' . RUNETID_HOST . '/vote/runet2015' => ['competence/main/index/', 'defaultParams' => ['id' => 42]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/runet2015/process' => ['competence/main/process/', 'defaultParams' => ['id' => 42]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/runet2015/done' => ['competence/main/done', 'defaultParams' => ['id' => 42]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/runet2015/after' => ['competence/main/after', 'defaultParams' => ['id' => 42]],
    
    SCHEMA . '://' . RUNETID_HOST . '/vote/digitalindex15' => 'competence/digitalindex15/index/',
    SCHEMA . '://' . RUNETID_HOST . '/vote/digitalindex15/process' => ['competence/main/process/', 'defaultParams' => ['id' => 43]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/digitalindex15/done' => ['competence/main/done', 'defaultParams' => ['id' => 43]],
    SCHEMA . '://' . RUNETID_HOST . '/vote/digitalindex15/after' => ['competence/main/after', 'defaultParams' => ['id' => 43]],

    SCHEMA . '://vote.' . RUNETID_HOST . '/iidf' => ['competence/iidf/index', 'defaultParams' => ['code' => 'iidf15']],
    SCHEMA . '://vote.' . RUNETID_HOST . '/iidf/<action:\w+>' => ['competence/iidf/<action>', 'defaultParams' => ['code' => 'iidf15']],

    SCHEMA . '://vote.' . RUNETID_HOST . '/<eventIdName:\w+>' => 'competence/event/index',
    SCHEMA . '://vote.' . RUNETID_HOST . '/<eventIdName:\w+>/<action:\w+>' => 'competence/event/<action>',

    /** OAuth Module */
    SCHEMA . '://'. RUNETID_HOST.'/oauth/social/request/<social:\d+>' => 'oauth/social/request',
    SCHEMA . '://'.RUNETID_HOST.'/oauth/paypal/redirect' => 'oauth/paypal/redirect',
    '/oauth/<controller:\w+>/<action:\w+>' => 'oauth/<controller>/<action>',

    SCHEMA . '://'.RUNETID_HOST.'/oauth/social/connect/social/22' => ['oauth/social/connect/', 'defaultParams' => ['social' => 22]],



    /** API Module Rules */
    'http://api.'.RUNETID_HOST.'/event/section/<action>' => 'api/section/<action>',
    'http://api.'.RUNETID_HOST.'/event/role/list' => 'api/event/roles',
    'http://api.'.RUNETID_HOST.'/pay/filter/list' => 'api/pay/filterlist',
    'http://api.'.RUNETID_HOST.'/pay/filter/book' => 'api/pay/filterbook',

    'http://api.'.RUNETID_HOST.'/raec/commission/list' => 'api/raec/commissionlist',
    'http://api.'.RUNETID_HOST.'/raec/commission/users' => 'api/raec/commissionusers',

    'http://api.'.RUNETID_HOST.'/iri/<Type:(expert|director|program)>/<action:\w+>' => 'api/iri/user<action>',
    'http://api.'.RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'api/<controller>/<action>',

    /** PAY Module Rules */
    SCHEMA . '://pay.'. RUNETID_HOST.'/<eventIdName>/' => 'pay/cabinet/index',
    SCHEMA . '://pay.'. RUNETID_HOST.'/register/<eventIdName>/' => 'pay/cabinet/register',

    SCHEMA . '://pay.'. RUNETID_HOST.'/create/<eventIdName>/' => 'pay/juridical/create',

    SCHEMA . '://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/<clear>/' => 'pay/order/index',
    SCHEMA . '://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/' => 'pay/order/index',
    SCHEMA . '://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/' => 'pay/order/index',

    SCHEMA . '://pay.'.RUNETID_HOST.'/callback/index/<addition>/' => ['pay/callback/index', 'defaultParams' => ['addition' => null]],
    SCHEMA . '://pay.'.RUNETID_HOST.'/callback/<action:\w+>/' => 'pay/callback/<action>',

    SCHEMA . '://pay.'. RUNETID_HOST.'/auth/<eventIdName>/<runetId:\d+>/<hash>/' => 'pay/cabinet/auth',

    /** Main Rules */
    SCHEMA . '://'. RUNETID_HOST.'/' => 'main/default/index',
    SCHEMA . '://'. RUNETID_HOST.'/<runetId:\d+>/' => 'user/view/index',

    SCHEMA . '://'. RUNETID_HOST.'/events/<Year:\d{4}>/<Month:\d{1,2}>' => 'event/list/index',
    SCHEMA . '://'. RUNETID_HOST.'/events/' => 'event/list/index',

    SCHEMA . '://'. RUNETID_HOST.'/event/<idName>/' => 'event/view/index',
    SCHEMA . '://'. RUNETID_HOST.'/event/<idName>/users/' => 'event/view/users',
    SCHEMA . '://'. RUNETID_HOST.'/event/<idName>/shareTo:<targetService>' => 'event/view/share',
    SCHEMA . '://'. RUNETID_HOST.'/event/<idName>/invite/<code>/' => 'event/invite/index',

    SCHEMA . '://'. RUNETID_HOST.'/ticket/<eventIdName>/<runetId>/<hash>/' => 'event/ticket/index',

    SCHEMA . '://'. RUNETID_HOST.'/create/' => 'event/create/index',

    SCHEMA . '://'. RUNETID_HOST.'/user/edit/' => 'user/edit/index',
    SCHEMA . '://'. RUNETID_HOST.'/user/setting/' => 'user/setting/password',
    SCHEMA . '://'. RUNETID_HOST.'/user/unsubscribe/' => 'user/unsubscribe/index',

    SCHEMA . '://'. RUNETID_HOST.'/companies/' => 'company/list/index',
    SCHEMA . '://'. RUNETID_HOST.'/company/<companyId:\d+>/' => 'company/view/index',

    SCHEMA . '://'. RUNETID_HOST.'/job/' => 'job/default/index',

    SCHEMA . '://'. RUNETID_HOST.'/courses/' => 'buduguru/course/list',

    SCHEMA . '://'. RUNETID_HOST.'/search/' => 'search/result/index',
    SCHEMA . '://'. RUNETID_HOST.'/contacts/' => 'page/info/contacts',
    SCHEMA . '://'. RUNETID_HOST.'/features/' => 'page/info/features',
    SCHEMA . '://'. RUNETID_HOST.'/ecosystems/' => 'page/info/ecosystems',

    /*** ОПРОС Карена **/
    SCHEMA . '://'. RUNETID_HOST.'/<_hr:(HR|hr|Hr|hR)>/' => 'page/content/hr',

    SCHEMA . '://<domain:\w+>.'. RUNETID_HOST .'/user/ajax/<action:\w+>' => 'user/ajax/<action>',
    SCHEMA . '://<domain:\w+>.'. RUNETID_HOST .'/pay/ajax/<action:\w+>' => 'pay/ajax/<action>',
    SCHEMA . '://<domain:\w+>.'. RUNETID_HOST .'/event/ajax/<action:\w+>' => 'event/ajax/<action>',
    SCHEMA . '://<domain:\w+>.'. RUNETID_HOST .'/company/ajax/<action:\w+>' => 'company/ajax/<action>',
    SCHEMA . '://<domain:\w+>.'. RUNETID_HOST .'/geo/ajax/<action:\w+>' => 'geo/ajax/<action>',

    /** Настройка путей админки */
    SCHEMA . '://admin.' .  RUNETID_HOST . '/' => 'main/admin/default/index',
    SCHEMA . '://admin.' .  RUNETID_HOST . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',

    /** РАЭК */
    SCHEMA . '://'. RUNETID_HOST.'/raec/brief/' => 'raec/brief/index',

    /** ALL MODULES */
    SCHEMA . '://'. RUNETID_HOST.'/fastauth/<runetId:\d+>/<hash>/' => 'main/fastauth/index',
    SCHEMA . '://'. RUNETID_HOST.'/register/<runetId:\d+>/<eventIdName>/<roleId:\d+>/<hash>/' => 'event/fastregister/index',

    SCHEMA . '://'. RUNETID_HOST.'/<module:\w+>/<controller:\w+>/<action:[\w-]+>' => '<module>/<controller>/<action>',


    SCHEMA . '://'. RUNETID_HOST.'/<module:\w+>/exclusive/<controller:\w+>/<action:\w+>' => '<module>/exclusive/<controller>/<action>',


    //TODO: Удалить 2 строчки после svyaz16
    'http://api.'.RUNETID_HOST.'/fastauth/<runetId:\d+>/<hash>/' => 'main/fastauth/index',
    'http://api.'.RUNETID_HOST.'/competence/main/all/' => 'competence/main/all'
];
