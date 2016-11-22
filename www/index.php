<?php

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH.'/config/init.php';
require BASE_PATH.'/protected/Yii.php';
require BASE_PATH.'/vendor/autoload.php';

Yii::createWebApplication(BASE_PATH.'/config/main.php')->run();