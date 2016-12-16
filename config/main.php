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
            'class' => 'CXCache'
        ],
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
            'timeout' => 15552000,
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

// Костыль для выключения поддержки сессий в api.
// toDo: Вывести api в отдельное приложение с собственным конфигом
if (preg_match('#^(api|ruvents)\.#', $_SERVER['HTTP_HOST'])) {
    $config['components']['session'] = [
        'autoStart' => false,
        'cookieMode' => 'none'
    ];
}

$config = CMap::mergeArray($config, require 'db.php');
$config = CMap::mergeArray($config, require 'api.php');
$config = CMap::mergeArray($config, require 'partner.php');
$config = CMap::mergeArray($config, require 'ruvents.php');
$config = CMap::mergeArray($config, require 'ruvents2.php');

$config['components']['urlManager']['rules'] = CMap::mergeArray(
    $config['components']['urlManager']['rules'],
    require 'routes.php'
);

if (YII_DEBUG) {
    $config['components']['debug'] = [
        'class' => 'ext.yii2-debug.Yii2Debug',
        'allowedIPs' => ['127.0.0.1', '::1', '82.142.129.37 '],
    ];
    // Большая совместимость с современными версиями php для окружения разработчика
    if (strpos(phpversion(), '7.') === 0) {
        // xCache пока не работает в
        if (strpos(phpversion(), '7.1') === 0) {
            unset($config['components']['cache']);
        }
        // Монга тоже не подходит
        unset($config['components']['mongodb']);
    }
}

CHtml::setModelNameConverter(function ($model) {
    return get_class($model);
});

return $config;
