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
        'http://login.'.RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'oauth/<controller>/<action>',

        
        /** INDEX PAGE */
        'http://'. RUNETID_HOST.'/' => 'main/default/index',
        
        /** ALL MODULES */
        'http://'. RUNETID_HOST.'/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',