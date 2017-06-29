<?php

ini_set('memory_limit', '2048M');

date_default_timezone_set('Europe/Moscow');

define('STDIN', fopen('php://stdin', 'r'));
define('BASE_PATH', dirname(__DIR__));

require BASE_PATH.'/vendor/autoload.php';
require BASE_PATH.'/config/init.php';
require BASE_PATH.'/protected/Yii.php';

$dirname = dirname(__FILE__);

Yii::setPathOfAlias('webroot', BASE_PATH.'/www/');

$app = Yii::createConsoleApplication(BASE_PATH.'/config/console.php');
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');

$env = @getenv('YII_CONSOLE_COMMANDS');
if (false === empty($env)) {
    $app->commandRunner->addCommands($env);
}

$app->run();
