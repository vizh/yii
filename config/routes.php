<?php
return array(
  'components' => array(
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix'=>'/',
      'useStrictParsing' => true,
      'rules' => array(

        /** PHDays2014 */
        'http://phdays2014.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'phdays2014')),
        'http://phdays2014.'.RUNETID_HOST.'/register/' => array('pay/cabinet/register/', 'defaultParams' => array('eventIdName' => 'phdays2014')),
        'http://phdays2014.'.RUNETID_HOST.'/pay/' => array('pay/cabinet/index/', 'defaultParams' => array('eventIdName' => 'phdays2014')),
        'http://phdays2014.'.RUNETID_HOST.'/create/' => array('pay/juridical/create/', 'defaultParams' => array('eventIdName' => 'phdays2014')),

        /** Mblt 2013 */
        'http://mblt2013.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'mblt2013')),
        'http://mblt2013.'.RUNETID_HOST.'/register/' => array('pay/cabinet/register/', 'defaultParams' => array('eventIdName' => 'mblt2013')),
        'http://mblt2013.'.RUNETID_HOST.'/pay/' => array('pay/cabinet/index/', 'defaultParams' => array('eventIdName' => 'mblt2013')),
        'http://mblt2013.'.RUNETID_HOST.'/create/' => array('pay/juridical/create/', 'defaultParams' => array('eventIdName' => 'mblt2013')),

        /** Demo 2013 */
        'http://demo2013.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'demo2013')),
        'http://demo2013.'.RUNETID_HOST.'/register/' => array('pay/cabinet/register/', 'defaultParams' => array('eventIdName' => 'demo2013')),
        'http://demo2013.'.RUNETID_HOST.'/pay/' => array('pay/cabinet/index/', 'defaultParams' => array('eventIdName' => 'demo2013')),
        'http://demo2013.'.RUNETID_HOST.'/create/' => array('pay/juridical/create/', 'defaultParams' => array('eventIdName' => 'demo2013')),
        'http://demo2013.'.RUNETID_HOST.'/pay/alley/' => array('event/exclusive/demo2013/alley/', 'defaultParams' => array('eventIdName' => 'demo2013')),
        'http://demo2013.'.RUNETID_HOST.'/exibitionlinks/' => array('event/exclusive/demo2013/exibitionlinks/', 'defaultParams' => array('eventIdName' => 'demo2013')),
          
        /** PhDays 2013 */
        'http://phdays2013.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'phdays2013')),
        'http://phdays2013.'.RUNETID_HOST.'/register/' => array('pay/cabinet/register/', 'defaultParams' => array('eventIdName' => 'phdays2013')),
        'http://phdays2013.'.RUNETID_HOST.'/pay/' => array('pay/cabinet/index/', 'defaultParams' => array('eventIdName' => 'phdays2013')),
        'http://phdays2013.'.RUNETID_HOST.'/create/' => array('pay/juridical/create/', 'defaultParams' => array('eventIdName' => 'phdays2013')),
          
        /** TC 2013 */
        'http://tc2013.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'tc2013')),
        'http://tc2013.'.RUNETID_HOST.'/register/' => array('pay/cabinet/register/', 'defaultParams' => array('eventIdName' => 'tc2013')),
        'http://tc2013.'.RUNETID_HOST.'/pay/' => array('pay/cabinet/index/', 'defaultParams' => array('eventIdName' => 'tc2013')),
        'http://tc2013.'.RUNETID_HOST.'/create/' => array('pay/juridical/create/', 'defaultParams' => array('eventIdName' => 'tc2013')),



        /** Mail.ru Test 2013 */
        'http://'.RUNETID_HOST.'/proftest/' => ['competence/main/index/', 'defaultParams' => ['id' => 6]],
        'http://'.RUNETID_HOST.'/proftest/process/' => ['competence/main/process/', 'defaultParams' => ['id' => 6]],
        'http://'.RUNETID_HOST.'/proftest/end' => ['competence/main/end/', 'defaultParams' => ['id' => 6]],
        'http://'.RUNETID_HOST.'/proftest/done' => ['competence/main/done/', 'defaultParams' => ['id' => 6]],

        /** iResearch 2013 */
        'http://'.RUNETID_HOST.'/iresearch2013/' => ['competence/main/index/', 'defaultParams' => ['id' => 2]],
        'http://'.RUNETID_HOST.'/iresearch2013/process/' => ['competence/main/process/', 'defaultParams' => ['id' => 2]],
        'http://'.RUNETID_HOST.'/iresearch2013/end' => ['competence/main/end/', 'defaultParams' => ['id' => 2]],
        'http://'.RUNETID_HOST.'/iresearch2013/done' => ['competence/main/done/', 'defaultParams' => ['id' => 2]],


        /** Student Test 2013 */
        'http://'.RUNETID_HOST.'/student/' => ['competence/main/index/', 'defaultParams' => ['id' => 3]],
        'http://'.RUNETID_HOST.'/student/process/' => ['competence/main/process/', 'defaultParams' => ['id' => 3]],
        'http://'.RUNETID_HOST.'/student/end' => ['competence/main/end/', 'defaultParams' => ['id' => 3]],
        'http://'.RUNETID_HOST.'/student/done' => ['competence/main/done/', 'defaultParams' => ['id' => 3]],
          
          
        /** Partner Module Rules */
        'http://partner.'. RUNETID_HOST.'/' => 'partner/main/index',
        'http://partner.'. RUNETID_HOST.'/auth/' => 'partner/auth/index',
        'http://partner.'. RUNETID_HOST.'/user/edit/<action:\w+>' => 'partner/userEdit/<action>',
        'http://partner.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'partner/<controller>/<action>',



        /** Ruvents Module Rules */
        'http://ruvents.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents/<controller>/<action>',

        /** OAuth Module */
        'http://'.RUNETID_HOST.'/oauth/paypal/redirect' => 'oauth/paypal/redirect',
        '/oauth/<controller:\w+>/<action:\w+>' => 'oauth/<controller>/<action>',


        /** API Module Rules */
        'http://api.'.RUNETID_HOST.'/event/section/<action>' => 'api/section/<action>',
        'http://api.'.RUNETID_HOST.'/event/role/list' => 'api/event/roles',
        'http://api.'.RUNETID_HOST.'/pay/filter/list' => 'api/pay/filterlist',
        'http://api.'.RUNETID_HOST.'/pay/filter/book' => 'api/pay/filterbook',

        'http://api.'.RUNETID_HOST.'/raec/commission/list' => 'api/raec/commissionlist',
        'http://api.'.RUNETID_HOST.'/raec/commission/users' => 'api/raec/commissionusers',




        'http://api.'.RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'api/<controller>/<action>',

        /** PAY Module Rules */
        'http://pay.'. RUNETID_HOST.'/<eventIdName>/' => 'pay/cabinet/index',
        'http://pay.'. RUNETID_HOST.'/register/<eventIdName>/' => 'pay/cabinet/register',

        'http://pay.'. RUNETID_HOST.'/create/<eventIdName>/' => 'pay/juridical/create',

        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/<clear>/' => 'pay/order/index',
        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/' => 'pay/order/index',
        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/' => 'pay/order/index',

        'http://pay.'.RUNETID_HOST.'/callback/<action:\w+>/' => 'pay/callback/<action>',

        'http://pay.'. RUNETID_HOST.'/auth/<eventIdName>/<runetId:\d+>/<hash>/' => 'pay/cabinet/auth',

        /** Main Rules */
        'http://'. RUNETID_HOST.'/' => 'main/default/index',
        'http://'. RUNETID_HOST.'/<runetId:\d+>/' => 'user/view/index',

        'http://'. RUNETID_HOST.'/events/<Year:\d{4}>/<Month:\d{1,2}>' => 'event/list/index',
        'http://'. RUNETID_HOST.'/events/' => 'event/list/index',

        'http://'. RUNETID_HOST.'/event/<idName>/' => 'event/view/index',
        'http://'. RUNETID_HOST.'/event/<idName>/users/' => 'event/view/users',
        'http://'. RUNETID_HOST.'/event/<idName>/shareTo:<targetService>' => 'event/view/share',
        'http://'. RUNETID_HOST.'/event/<idName>/invite/<code>/' => 'event/invite/index',
        'http://'. RUNETID_HOST.'/ticket/<eventIdName>/<runetId>/<hash>/' => 'event/ticket/index',

        'http://'. RUNETID_HOST.'/create/' => 'event/create/index',
        
        'http://'. RUNETID_HOST.'/user/edit/' => 'user/edit/index',
        'http://'. RUNETID_HOST.'/user/setting/' => 'user/setting/password',
        'http://'. RUNETID_HOST.'/user/unsubscribe/' => 'user/unsubscribe/index',

        'http://'. RUNETID_HOST.'/companies/' => 'company/list/index',
        'http://'. RUNETID_HOST.'/company/<companyId:\d+>/' => 'company/view/index',

        'http://'. RUNETID_HOST.'/job/' => 'job/default/index',

        'http://'. RUNETID_HOST.'/search/' => 'search/result/index',
        'http://'. RUNETID_HOST.'/contacts/' => 'page/info/contacts',
        'http://'. RUNETID_HOST.'/features/' => 'page/info/features',

        /*** ОПРОС Карена **/
        'http://'. RUNETID_HOST.'/<_hr:(HR|hr|Hr|hR)>/' => 'page/content/hr',



        'http://<domain:\w+>.'. RUNETID_HOST .'/user/ajax/<action:\w+>' => 'user/ajax/<action>',  
        'http://<domain:\w+>.'. RUNETID_HOST .'/pay/ajax/<action:\w+>' => 'pay/ajax/<action>',   
        'http://<domain:\w+>.'. RUNETID_HOST .'/event/ajax/<action:\w+>' => 'event/ajax/<action>', 
        'http://<domain:\w+>.'. RUNETID_HOST .'/company/ajax/<action:\w+>' => 'company/ajax/<action>',   
        'http://<domain:\w+>.'. RUNETID_HOST .'/contact/ajax/<action:\w+>' => 'contact/ajax/<action>',     
          
        /** Настройка путей админки */
        'http://admin.' .  RUNETID_HOST . '/' => 'main/admin/default/index',
        'http://admin.' .  RUNETID_HOST . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',

          
        /** ALL MODULES */
        'http://'. RUNETID_HOST.'/fastauth/<runetId:\d+>/<hash>/' => 'main/fastauth/index',
        'http://'. RUNETID_HOST.'/register/<runetId:\d+>/<eventIdName>/<roleId:\d+>/<hash>/' => 'event/fastregister/index',

        'http://'. RUNETID_HOST.'/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            
          
        'http://'. RUNETID_HOST.'/<module:\w+>/exclusive/<controller:\w+>/<action:\w+>' => '<module>/exclusive/<controller>/<action>',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
