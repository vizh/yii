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


        /** Demo 2013 */
        'http://demo2013.'.RUNETID_HOST.'/' => array('event/view/index/', 'defaultParams' => array('idName' => 'demo2013')),





        /** Настройка путей админки */
        'http://admin.' .  RUNETID_HOST . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',

        /** Partner Module Rules */
        'http://partner.'. RUNETID_HOST.'/' => 'partner/main/index',
        'http://partner.'. RUNETID_HOST.'/auth/' => 'partner/auth/index',
        'http://partner.'. RUNETID_HOST.'/user/edit/<action:\w+>' => 'partner/userEdit/<action>',
        'http://partner.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'partner/<controller>/<action>',



        /** Ruvents Module Rules */
        'http://ruvents.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents/<controller>/<action>',

        /** OAuth Module */
        //'http://login.'.RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'oauth/<controller>/<action>',

        /** API Module Rules */
        'http://api.'.RUNETID_HOST.'/event/role/list' => 'api/event/roles',
        'http://api.'.RUNETID_HOST.'/pay/filter/list' => 'api/pay/filterlist',
        'http://api.'.RUNETID_HOST.'/pay/filter/book' => 'api/pay/filterbook',

        'http://api.'.RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'api/<controller>/<action>',

        /** PAY Module Rules */
        'http://pay.'. RUNETID_HOST.'/<eventIdName>/' => 'pay/cabinet/index',
        'http://pay.'. RUNETID_HOST.'/register/<eventIdName>/' => 'pay/cabinet/register',

        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/<clean>/' => 'pay/juridical/order',
        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/<hash>/' => 'pay/juridical/order',
        'http://pay.'. RUNETID_HOST.'/order/<orderId:\d+>/' => 'pay/juridical/order',

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


        'http://'. RUNETID_HOST.'/job/' => 'job/default/index',


        
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