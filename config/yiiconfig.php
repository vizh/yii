<?php



// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'protected',
  'name'=>'RUNET-ID',
  'sourceLanguage' => 'ru',
  'language' => 'ru',

  // preloading 'log' component
  'preload'=>array('log', 'session'),

  // autoloading model and component classes
  'import'=>array(
    'application.components.Utils',
    'application.helpers.*'
   ),



  // application components
  'components'=>array(

    'user'=>array(
      'loginUrl' => array('/oauth/main/auth', 'url' => $_SERVER['REQUEST_URI']),
      'class' => '\application\components\auth\WebUser',
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
      //'autoRenewCookie' => true,
      'identityCookie' => array('domain' => '.'.RUNETID_HOST),
    ),

    'authManager' => array(
      'class' => '\application\components\auth\PhpAuthManager',
      'defaultRoles' => array('guest')
    ),

    'cache'=>array(
      'class'=>'CXCache',
      //'class'=>'CDummyCache'
    ),

    'db'=>array(
      'class'=>'\application\components\db\PgDbConnection',
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
      'connectionString' => 'mysql:host=109.234.156.202;dbname=rocid',
      'emulatePrepare' => true,
      'username' => 'rocid',
      'password' => 'Coozeiph8toh1dik',
      'charset' => 'utf8',
      'enableProfiling' => true,
      'enableParamLogging'=>true,
      'schemaCachingDuration'=>3600,
    ),
      
    'image'=>array(
      'class'=>'application.extensions.image.CImageComponent',
      'driver'=>'GD',
    ),
      
    'session' => array(
      'class' => '\application\components\web\PgDbHttpSession',
      'connectionID' => 'db',
      'autoCreateSessionTable' => false, //!!!
      'sessionName' => 'sessid',
      'timeout' => 180 * 24 * 60 * 60,
      'cookieParams' => array(
        'lifetime' => 180 * 24 * 60 * 60,
        'domain' => '.'.RUNETID_HOST
      ),
    ),

    'request'=>array(
      'enableCookieValidation'=>true,
    ),

    'errorHandler'=>array(
      'errorAction'=>'/main/error/index',
    ),

    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CProfileLogRoute',
          'levels'=>'profile',
          'enabled'=>true,
        ),
        array(
          'class' => 'CWebLogRoute',
          'categories' => 'application',
          'levels'=>'error, warning, info',
        ),
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
      ),
    ),
  ),

);
