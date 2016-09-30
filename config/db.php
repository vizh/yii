<?php

if (YII_DEBUG) {
    if (DOCKERIZED) {
        return [ // Настройки подключения к базе в докеризованном окружении
            'class' => '\application\components\db\PgDbConnection',
            'connectionString' => "{$_ENV['DATABASE_TYPE']}:host={$_ENV['DATABASE_HOSTNAME']};port={$_ENV['DATABASE_PORT']};dbname={$_ENV['DATABASE_DATABASE']}",
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 600
        ];
    }

    // Для олдскульщиков оставляем возможность создать рядышком
    // файлик db.dev.php в котором можно задать собственные настройки
    if (!file_exists('db.dev.php')) {
        ?>
        <center style="display:block;margin:5em auto;width:60%;font-size:22px">
            <font color="red">ВНИМАНИЕ!</font>
            <p>В недокеризованном окружении, в режиме разработки необходимо создать файл настроек подключения к базе данных /config/db.dev.php с примерно таким содержанием:</p>
            <textarea cols="70" rows="11">
                return [
                    'class' => '\application\components\db\PgDbConnection',
                    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=runetid',
                    'username' => '{{логин}}',
                    'password' => '{{пароль}}',
                    'emulatePrepare' => true,
                    'charset' => 'utf8',
                    'enableProfiling' => true,
                    'enableParamLogging' => true,
                    'schemaCachingDuration' => 600
                ];
            </textarea>
        </center>
        <?
        exit;
    }

    /** @noinspection PhpIncludeInspection */
    return require __DIR__.'db.dev.php';
}

return [ // Настройки подключения к боевой базе.
    'class' => '\application\components\db\PgDbConnection',
    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=runetid',
    'username' => 'runetid',
    'password' => 'uRaiy1ThiexaGhai',
    'emulatePrepare' => true,
    'charset' => 'utf8',
    'enableProfiling' => true,
    'enableParamLogging' => true,
    'schemaCachingDuration' => 600
];
