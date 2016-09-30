<?php

Yii::setPathOfAlias('vendor', __DIR__.'/../vendor');

$config = [
    'basePath' => BASE_PATH.'/protected',
    'name' => 'RUNET-ID',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'preload' => ['log', 'session', 'debug'],
    'import' => [
        'application.components.Utils',
        'application.helpers.*',
        'vendor.sammaye.mongoyii.*',
        'vendor.sammaye.mongoyii.validators.*',
        'vendor.sammaye.mongoyii.behaviors.*',
        'vendor.sammaye.mongoyii.util.*',
    ],
    'components' => [
        'user' => [
            'loginUrl' => ['/oauth/main/auth', 'url' => $_SERVER['REQUEST_URI']],
            'class' => 'application\components\auth\WebUser',
            'allowAutoLogin' => true,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST],
        ],
        'tempUser' => [
            'class' => '\application\components\auth\WebUser',
            'stateKeyPrefix' => 'tempUser',
            'loginUrl' => null,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST],
        ],
        'authManager' => [
            'class' => 'application\components\auth\PhpAuthManager',
            'defaultRoles' => ['guest'],
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
            'useStrictParsing' => true,
            'rules' => [],
        ],
        'cache' => [
            'class' => 'EMongoCache',
        ],
        'db' => require 'db.php',
        'image' => [
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
        ],
        'mobileDetect' => [
            'class' => 'ext.MobileDetect.MobileDetect',
        ],
        'session' => [
            'class' => 'application\components\web\PgDbHttpSession',
            'connectionID' => 'db',
            'autoCreateSessionTable' => true,
            'sessionName' => 'sessid',
            'timeout' => 180 * 24 * 60 * 60,
            'gCProbability' => 1,
            'cookieParams' => ['lifetime' => 0, 'domain' => '.'.RUNETID_HOST, 'httponly' => true],
        ],
        'request' => [
            'class' => '\application\components\HttpRequest',
            'enableCookieValidation' => true,
        ],
        'errorHandler' => [
            'errorAction' => '/main/error/index',
        ],
        'mongodb' => require 'mongo-db.php',
        'log' => [
            'class' => 'CLogRouter',
            'routes' => require 'log-routes.php',
        ],
        'clientScript' => [
            'packages' => require 'script-packages.php',
            'scriptMap' => [],
        ],
    ],
    'modules' => require 'modules.php',
    'params' => require 'params.php',
];

$config = CMap::mergeArray($config, require 'api.php');
$config = CMap::mergeArray($config, require 'partner.php');
$config = CMap::mergeArray($config, require 'ruvents.php');
$config = CMap::mergeArray($config, require 'ruvents2.php');

$config['components']['urlManager']['rules'] = CMap::mergeArray($config['components']['urlManager']['rules'],
    require 'url-rules.php');

if (YII_DEBUG) {
    $config['components']['debug'] = [
        'class' => 'ext.yii2-debug.Yii2Debug',
        'allowedIPs' => ['127.0.0.1', '::1', '82.142.129.37 '],
    ];

    if (YII_DEBUG_DISABLE_CHACHE) {
        unset($config['components']['mongo']);
        $config['components']['cache'] = [
            'class' => 'CDummyCache'
        ];
    }
}

return $config;
