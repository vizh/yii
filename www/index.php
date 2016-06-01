<?php

if ( $_SERVER['REQUEST_URI'] == '/event/iri-forum-suver16/media/register' ) {
    header('Location: https://runet-id.com/event/iri-forum-suver16/');
    exit;
}

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH.'/config/init.php';
require BASE_PATH.'/protected/Yii.php';
require BASE_PATH.'/vendor/autoload.php';

Yii::createWebApplication(BASE_PATH.'/config/main.php')->run();