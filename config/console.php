<?php
$_SERVER['REQUEST_URI'] = '';
$_SERVER['SERVER_NAME'] = 'runet-id.com';
$mainAppConfig = require (dirname(__FILE__).'/main.php');
return [
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'protected',
  'name'=>'RUNET-ID',
  'sourceLanguage' => 'ru',
  'language' => 'ru',

  // autoloading model and component classes
  'import'=>[
    'application.components.Utils',
    'application.helpers.*'
   ],
    
  'behaviors'=>[
    'templater'=>'\application\components\console\ConsoleApplicationTemplater',
  ],
    
  // application components
  'components'=>[
    'db' => $mainAppConfig['components']['db'],
    'urlManager' => $mainAppConfig['components']['urlManager'],
    'image' => $mainAppConfig['components']['image'],
    'clientScript' => $mainAppConfig['components']['clientScript'],
    'widgetFactory' => ['class' => 'CWidgetFactory']
  ],
  'params' => $mainAppConfig['params'], 
  'modules' => $mainAppConfig['modules']
];
