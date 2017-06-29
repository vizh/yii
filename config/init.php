<?php

date_default_timezone_set('Europe/Moscow');

// Загрузка переменных окружения
if (false === isset($_ENV['DOCKER'])) {
    if (false !== $environment = parse_ini_file(__DIR__.'/.env', INI_SCANNER_RAW)) {
        foreach ($environment as $param => $value) {
            // Если проект запущен под apache используя mod_php и переопределяет наше значение
            if (true === function_exists('apache_setenv') && false !== apache_getenv($param)) {
                apache_setenv($param, $param);
            }
            // Для FastCGI используется другой способ
            if (true === function_exists('putenv')) {
                putenv("{$param}={$value}");
            }
            // Ну и для пущей уверенности
            $_ENV[$param] = $value;
        }
    } else {
        die('Опаньки! Отсутствует файл .env-файл. Подробности в README.md');
    }
}

define('YII_DEBUG', $_ENV['ENVIRONMENT'] !== 'production');
define('YII_TRACE_LEVEL', 3);
define('RUNETID_HOST', YII_DEBUG ? 'runet-id.dev' : 'runet-id.com');
define('SCHEMA', YII_DEBUG ? 'http' : 'https');

define('RUNETID_TIME_FORMAT', 'Y-m-d H:i:s');
