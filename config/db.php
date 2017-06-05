<?php

if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'db.local.php')) {
    return require_once 'db.local.php';
}

return [
    'components' => [
        'db' => [
            'class' => '\application\components\db\PgDbConnection',
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=runetid',
            'username' => 'runetid',
            'password' => 'uRaiy1ThiexaGhai',
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 600
        ],

        'mongodb' => [
            'class' => 'EMongoClient',
            'server' => 'mongodb://localhost',
            'db' => 'runetid'
        ]
    ]
];
