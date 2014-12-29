<?php

require(__DIR__.'/init.php');

$config = [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'protected',
    'name' => 'RUNET-ID',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'preload' => ['log', 'session', 'debug'],
    'import' => [
        'application.components.Utils',
        'application.helpers.*'
    ],
    'components' => [
        'user' => [
            'loginUrl' => ['/oauth/main/auth', 'url' => $_SERVER['REQUEST_URI']],
            'class' => '\application\components\auth\WebUser',
            'allowAutoLogin' => true,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST],
        ],
        'payUser' => [
            'class' => '\application\components\auth\WebUser',
            'stateKeyPrefix'=>'payUser',
            'loginUrl' => null,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST]
        ],
        'authManager' => [
            'class' => '\application\components\auth\PhpAuthManager',
            'defaultRoles' => ['guest']
        ],
        'urlManager' => [
            'urlFormat'=>'path',
            'showScriptName' => false,
            'urlSuffix'=>'/',
            'useStrictParsing' => true,
            'rules' => []
        ],
        'cache' => [
            'class'=>'CXCache',
        ],
        'db' => require(__DIR__.'/db.php'),
        'image' => [
            'class'=>'application.extensions.image.CImageComponent',
            'driver'=>'GD',
        ],
        'mobileDetect' => [
            'class' => 'ext.MobileDetect.MobileDetect'
        ],
        'session' => [
            'class' => '\application\components\web\PgDbHttpSession',
            'connectionID' => 'db',
            'autoCreateSessionTable' => false,
            'sessionName' => 'sessid',
            'timeout' => 180 * 24 * 60 * 60,
            'gCProbability' => 1,
            'cookieParams' => ['lifetime' => 0, 'domain' => '.'.RUNETID_HOST, 'httponly' => true]
        ],
        'request' => [
            'class' => '\application\components\HttpRequest',
            'enableCookieValidation' => true
        ],
        'errorHandler' => [
            'errorAction'=>'/main/error/index',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => require(__DIR__ . '/log-routes.php')
        ],
        'clientScript' => [
            'packages' => require(__DIR__ . '/script-packages.php'),
            'scriptMap' => []
        ]
    ],
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => require(__DIR__ . '/params.php')
];

$config = CMap::mergeArray($config, require(__DIR__ . '/api.php'));
$config = CMap::mergeArray($config, require(__DIR__ . '/partner.php'));
$config = CMap::mergeArray($config, require(__DIR__ . '/ruvents.php'));
$config = CMap::mergeArray($config, require(__DIR__ . '/ruvents2.php'));


$config['components']['urlManager']['rules'] = CMap::mergeArray($config['components']['urlManager']['rules'], require(__DIR__.'/url-rules.php'));

if (RUNETID_DEV) {
    $config['components']['debug'] = [
        'class' => 'ext.yii2-debug.Yii2Debug',
        'allowedIPs' => ['127.0.0.1', '::1', '82.142.129.37 ']
    ];
}

return $config;