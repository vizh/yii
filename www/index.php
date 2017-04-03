<?php

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH.'/vendor/autoload.php';
require BASE_PATH.'/config/init.php';
require BASE_PATH.'/protected/Yii.php';

Yii::createWebApplication(BASE_PATH.'/config/main.php')->run();

function tgmsg($data) {
    file_get_contents('https://api.telegram.org/bot217593085:AAG-Px7tznYlD76KL18aJa0rV8Ceh1BMiio/sendMessage?chat_id=-203177054&text='.json_encode($data));
}