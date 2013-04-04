<?php
return array(
  'components' => array(
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix'=>'/',
      'useStrictParsing' => true,
      'rules' => array(

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




        /** Настройка путей админки */
        'http://' .  RUNETID_HOST . '/admin/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
        'http://admin.' .  RUNETID_HOST . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
          
          
        /** Partner Module Rules */
        'http://partner.'. RUNETID_HOST.'/' => 'partner/main/index',
        'http://partner.'. RUNETID_HOST.'/auth/' => 'partner/auth/index',
        'http://partner.'. RUNETID_HOST.'/user/edit/<action:\w+>' => 'partner/userEdit/<action>',
        'http://partner.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'partner/<controller>/<action>',



        /** Ruvents Module Rules */
        'http://ruvents.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents/<controller>/<action>',

        /** OAuth Module */
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

        'http://pay.'.RUNETID_HOST.'/callback/index/' => 'pay/callback/index',

        'http://pay.'. RUNETID_HOST.'/auth/<eventIdName>/<runetId:\d+>/<hash>/' => 'pay/cabinet/auth',

        /** EVENT ICAL SHARE */
        'http://'. RUNETID_HOST.'/event/share/ical/<idName>/' => 'event/share/ical',

        /** Main Rules */
        'http://'. RUNETID_HOST.'/' => 'main/default/index',
        'http://'. RUNETID_HOST.'/<runetId:\d+>/' => 'user/view/index',

        'http://'. RUNETID_HOST.'/events/<Year:\d{4}>/<Month:\d{1,2}>' => 'event/list/index',
        'http://'. RUNETID_HOST.'/events/' => 'event/list/index',

        'http://'. RUNETID_HOST.'/events/calendar/<Year:\d{4}>/<Month:\d{1,2}>' => 'event/list/calendar',
        'http://'. RUNETID_HOST.'/events/calendar/' => 'event/list/calendar',

        'http://'. RUNETID_HOST.'/event/<idName>/' => 'event/view/index',
        
        'http://'. RUNETID_HOST.'/user/edit/' => 'user/edit/index',
        'http://'. RUNETID_HOST.'/user/setting/' => 'user/setting/password',

        'http://'. RUNETID_HOST.'/job/' => 'job/default/index',

        'http://'. RUNETID_HOST.'/search/' => 'search/result/index',


        
        'http://<domain:\w+>.'. RUNETID_HOST .'/user/ajax/<action:\w+>' => 'user/ajax/<action>',  
        'http://<domain:\w+>.'. RUNETID_HOST .'/pay/ajax/<action:\w+>' => 'pay/ajax/<action>',   
          
        /** ALL MODULES */
        'http://'. RUNETID_HOST.'/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
          
          
          
        'http://'. RUNETID_HOST.'/<module:\w+>/exclusive/<controller:\w+>/<action:\w+>' => '<module>/exclusive/<controller>/<action>',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
