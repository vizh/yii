<?php

$_SERVER['REQUEST_URI'] = '';
$_SERVER['SERVER_NAME'] = 'runet-id.com';

require __DIR__.'/init.php';

define('BASE_PATH', __DIR__.'/../www');

$mainAppConfig = require __DIR__.'/main.php';

return [
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'protected',
    'name' => 'RUNET-ID',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'import' => $mainAppConfig['import'],
    'behaviors' => ['templater' => '\application\components\console\ConsoleApplicationTemplater'],
    'preload' => ['log'],
    'components' => [
        'db' => $mainAppConfig['components']['db'],
        'mongodb' => $mainAppConfig['components']['mongodb'],
        'urlManager' => $mainAppConfig['components']['urlManager'],
        'image' => $mainAppConfig['components']['image'],
        'clientScript' => $mainAppConfig['components']['clientScript'],
        'widgetFactory' => ['class' => 'CWidgetFactory'],
        'log' => $mainAppConfig['components']['log']
    ],
    'params' => $mainAppConfig['params'],
    'modules' => $mainAppConfig['modules']
];
