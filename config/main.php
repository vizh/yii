<?php

Yii::setPathOfAlias('vendor', __DIR__.'/../vendor');

$config = [
    'basePath' => BASE_PATH.'/protected',
    'name' => 'RUNET-ID',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'preload' => ['log', 'session'],
    'import' => [
        'application.components.Utils',
        'application.helpers.*',
        'vendor.sammaye.mongoyii.*',
        'vendor.sammaye.mongoyii.validators.*',
        'vendor.sammaye.mongoyii.behaviors.*',
        'vendor.sammaye.mongoyii.util.*'
    ],
    'components' => [
        'db' => [
            'class' => '\application\components\db\PgDbConnection',
            'connectionString' => "pgsql:host={$_ENV['DATABASE_HOST']};port={$_ENV['DATABASE_PORT']};dbname={$_ENV['DATABASE_NAME']}",
            'username' => $_ENV['DATABASE_USER'],
            'password' => $_ENV['DATABASE_PASS'],
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 600
        ],
        'mongodb' => [
            'class' => 'EMongoClient',
            'server' => "mongodb://{$_ENV['MONGO_HOST']}",
            'db' => $_ENV['MONGO_NAME']
        ],
        'user' => [
            'loginUrl' => ['/oauth/main/auth', 'url' => $_SERVER['REQUEST_URI']],
            'class' => 'application\components\auth\WebUser',
            'allowAutoLogin' => true,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST]
        ],
        'tempUser' => [
            'class' => '\application\components\auth\WebUser',
            'stateKeyPrefix' => 'tempUser',
            'loginUrl' => null,
            'identityCookie' => ['domain' => '.'.RUNETID_HOST]
        ],
        'authManager' => [
            'class' => 'application\components\auth\PhpAuthManager',
            'defaultRoles' => ['guest']
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
            'useStrictParsing' => true,
            'rules' => []
        ],
        'cache' => [
            'class' => 'CXCache'
        ],
        'image' => [
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ],
        'mobileDetect' => [
            'class' => 'ext.MobileDetect.MobileDetect'
        ],
        'session' => [
            'class' => 'application\components\web\PgDbHttpSession',
            'connectionID' => 'db',
            'autoCreateSessionTable' => true,
            'sessionName' => 'sessid',
            'timeout' => 15552000,
            'gCProbability' => 1,
            'cookieParams' => ['lifetime' => 0, 'domain' => '.'.RUNETID_HOST, 'httponly' => true]
        ],
        'request' => [
            'class' => '\application\components\HttpRequest',
            'enableCookieValidation' => true
        ],
        'errorHandler' => [
            'class' => '\application\components\ErrorHandler',
            'errorAction' => '/main/error/index'
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => require __DIR__.'/log-routes.php'
        ],
        'clientScript' => [
            'packages' => require __DIR__.'/script-packages.php',
            'scriptMap' => []
        ]
    ],
    'modules' => require __DIR__.'/modules.php',
    'params' => require __DIR__.'/params.php'
];

// Костыль для выключения поддержки сессий в api.
// toDo: Вывести api в отдельное приложение с собственным конфигом
if (isset($_SERVER['HTTP_HOST']) && preg_match('#^(api|ruvents)\.#', $_SERVER['HTTP_HOST'])) {
    $config['components']['session'] = [
        'autoStart' => false,
        'cookieMode' => 'none'
    ];
}

$config = CMap::mergeArray($config, require __DIR__.'/api.php');
$config = CMap::mergeArray($config, require __DIR__.'/partner.php');
$config = CMap::mergeArray($config, require __DIR__.'/ruvents.php');

$config['components']['urlManager']['rules'] = CMap::mergeArray(
    $config['components']['urlManager']['rules'],
    require __DIR__.'/routes.php'
);

// Совместимость с php 7.0
if (strpos(PHP_VERSION, '7.') === 0) {
    $config['components']['cache'] = [
        'class' => 'CApcCache',
        'useApcu' => true
    ];
}

if (YII_DEBUG) {
    // Если расширение Yii2Debug действительно установлено, а то composer install --no-dev может быть
    if (file_exists(__DIR__.'/../vendor/zhuravljov/yii2-debug/Yii2Debug.php')) {
        $config['preload'][] = 'debug';
        $config['components']['debug'] = [
            'class' => 'vendor.zhuravljov.yii2-debug.Yii2Debug',
            'allowedIPs' => ['*']
        ];
    }
    // Большая совместимость с современными версиями php для окружения разработчика
    if (strpos(PHP_VERSION, '7.') === 0) {
        // Монга тоже не подходит
        unset($config['components']['mongodb']);
    }
}

CHtml::setModelNameConverter(function ($model) {
    return get_class($model);
});

return $config;
