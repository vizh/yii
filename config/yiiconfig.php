<?php



// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'protected',
  'name'=>'RUNET-ID',
  'sourceLanguage' => 'ru_ru',
  'language' => 'ru',

  // preloading 'log' component
  'preload'=>array('log'),

  // autoloading model and component classes
  'import'=>array(
    'application.components.Utils',
   ),



  // application components
  'components'=>array(

    'user'=>array(
      'class' => '\application\components\auth\WebUser',
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
      //'autoRenewCookie' => true,
      'identityCookie' => array('domain' => '.'.ROCID_HOST),
    ),

    'cache'=>array(
      'class'=>'CXCache',
      //'class'=>'CDummyCache'
    ),

    'db'=>array(
      'class'=>'CDbConnection',
      'connectionString' => 'pgsql:host=runetid.internetmediaholding.com;port=5432;dbname=runetid',
      'emulatePrepare' => true,
      'username' => 'runetid',
      'password' => 'Rofeena1jei8haes',
      'charset' => 'utf8',
      'enableProfiling' => true,
      'enableParamLogging'=>true,
      'schemaCachingDuration'=>600,
    ),
    'dbOld'=>array(
      'class'=>'CDbConnection',
      'connectionString' => 'mysql:host=localhost;dbname=rocidbeta',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => '123456',
      'charset' => 'utf8',
      'enableProfiling' => true,
      'enableParamLogging'=>true,
      'schemaCachingDuration'=>3600,
    ),

    'session' => array(
      'class' => 'CDbHttpSession',
      'connectionID' => 'dbOld',
      'autoCreateSessionTable' => false, //!!!
      'sessionName' => 'sessid',
      'timeout' => 180 * 24 * 60 * 60,
      'cookieParams' => array(
        'lifetime' => 180 * 24 * 60 * 60,
        'domain' => '.'.ROCID_HOST
      ),
    ),

    'request'=>array(
      'enableCookieValidation'=>true,
    ),

    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
      ),
    ),
  ),

);