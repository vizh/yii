<?php

return array(
  'components' => array(
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix'=>'/',
      //'useStrictParsing' => true,
      'rules' => array(
        /** Настройка путей админки */
        'http://' . ROCID_HOST . '/admin/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
        'http://' . ROCID_HOST . '/admin/<module:\w+>/<controller:\w+>' => '<module>/admin/<controller>',


        'http://zapi.'.ROCID_HOST.'/<controller:\w+>/<action:\w+>' => 'api/<controller>/<action>',

        '',
      ),
    ),
  )
);

//        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',