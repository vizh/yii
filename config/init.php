<?php

date_default_timezone_set('Europe/Moscow');

define('YII_DEBUG', substr($_SERVER['HTTP_HOST'], -4) === '.dev');
define('YII_TRACE_LEVEL', 3);
define('RUNETID_HOST', YII_DEBUG ? 'runet-id.dev' : 'runet-id.com');
define('SCHEMA', YII_DEBUG ? 'http' : 'https');

define('RUNETID_TIME_FORMAT', 'Y-m-d H:i:s');
