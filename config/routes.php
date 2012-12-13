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
        'http://admin.' . ROCID_HOST . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',

        /** Partner Module Rules */
        'http://partner.'.ROCID_HOST.'/' => 'partner/main/index',
        'http://partner.'.ROCID_HOST.'/auth/' => 'partner/auth/index',
        'http://partner.'.ROCID_HOST.'/user/edit/<action:\w+>' => 'partner/userEdit/<action>',
        'http://partner.'.ROCID_HOST.'/<controller:\w+>/<action:\w+>' => 'partner/<controller>/<action>',



        /** Ruvents Module Rules */
        'http://ruvents.'.ROCID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents/<controller>/<action>',


        /** ALL MODULES */
        'http://'.ROCID_HOST.'/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',