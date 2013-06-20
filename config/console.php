<?php
$_SERVER['REQUEST_URI'] = '';
$mainAppConfig = require (dirname(__FILE__).'/main.php');
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'protected',
  'name'=>'RUNET-ID',
  'sourceLanguage' => 'ru',
  'language' => 'ru',

  // autoloading model and component classes
  'import'=>array(
    'application.components.Utils',
    'application.helpers.*'
   ),
    
  'behaviors'=>array(
    'templater'=>'\application\components\console\ConsoleApplicationTemplater',
  ),
    
  // application components
  'components'=>array(
    'db' => $mainAppConfig['components']['db'],
    'urlManager' => $mainAppConfig['components']['urlManager']
  ),
    
  'modules' => $mainAppConfig['modules']
);