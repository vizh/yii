<?php
// отключаем отладку
define('YII_DEBUG', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '82.142.129.35', '178.140.224.229', '10.10.4.1', '::1']));
define('YII_TRACE_LEVEL',3);

$yii=dirname(__FILE__).'/../protected/Yii.php';

date_default_timezone_set('Europe/Moscow');

$config=dirname(__FILE__).'/../config/main.php';

require_once($yii);
$vendor=dirname(__FILE__).'/../vendor/autoload.php';
require_once($vendor);

$app = Yii::createWebApplication($config);
$app->run();