<?php
// change the following paths if necessary
$config=dirname(__FILE__).'/../config/console.php';
date_default_timezone_set('Europe/Moscow');

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('YII_DEBUG') or define('YII_DEBUG',false);
require_once(dirname(__FILE__).'/Yii.php');
if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

\Yii::setPathOfAlias('webroot',dirname(__FILE__).'/../www/');
$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

$app->run();