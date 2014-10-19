<?php
//$runetId = 454;
//$hash = substr(md5('fiNAQ3t32RYn9HTGkEdKzRrYS'.$runetId), 1, 16);
//echo sprintf('http://mbltdev.ru/?RunetId=%s&Hash=%s', $runetId, $hash);
//exit;

// отключаем отладку
$debug = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '82.142.129.35' || $_SERVER['REMOTE_ADDR'] == '178.140.224.229' || $_SERVER['REMOTE_ADDR'] == '10.10.4.1';

define('YII_DEBUG', true);
define('YII_TRACE_LEVEL',3);

$yii=dirname(__FILE__).'/../protected/Yii.php';

date_default_timezone_set('Europe/Moscow');

$config=dirname(__FILE__).'/../config/main.php';

require_once($yii);
$app = Yii::createWebApplication($config);
$app->run();