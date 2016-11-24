<?php

return [
    'components' => [
        'db' => [
            'class' => '\application\components\db\PgDbConnection',
            'connectionString' => "{$_ENV['DATABASE_TYPE']}:host={$_ENV['DATABASE_HOSTNAME']};port={$_ENV['DATABASE_PORT']};dbname={$_ENV['DATABASE_DATABASE']}",
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 600
        ],

        'mongodb' => [
            'class' => 'EMongoClient',
            'server' => "mongodb://{$_ENV['MONGO_HOSTNAME']}",
            'db' => $_ENV['runetid']
        ]
    ]
];
