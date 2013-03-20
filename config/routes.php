<?php
return array(
  'components' => array(
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix'=>'/',
      'useStrictParsing' => true,
      'rules' => array( 
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
        'api/event/role/list' => 'api/event/roles',
        'api/pay/filter/list' => 'api/pay/filterlist',
        'api/pay/filter/book' => 'api/pay/filterbook',

        /** EVENT ICAL SHARE */
        '/event/share/ical/<idName>/' => 'event/share/ical',

        /** Main Rules */
        'http://'. RUNETID_HOST.'/' => 'main/default/index',
        'http://'. RUNETID_HOST.'/<runetId:\d+>/' => 'user/view/index',
        'http://'. RUNETID_HOST.'/events/' => 'event/list/index',
        'http://'. RUNETID_HOST.'/calendar/' => 'event/list/calendar',
        
        /** ALL MODULES */
        'http://'. RUNETID_HOST.'/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',