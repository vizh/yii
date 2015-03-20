<?php

if (!YII_DEBUG)
{
return [
    'class' => '\application\components\db\PgDbConnection',
    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=runetid',
    'username' => 'runetid',
    'password' => 'ieBoo3thooDaer2E',
    'emulatePrepare' => true,
    'charset' => 'utf8',
    'enableProfiling' => true,
    'enableParamLogging' => true,
    'schemaCachingDuration' => 600
];
}
else
{
  return [
      'class' => '\application\components\db\PgDbConnection',
      'connectionString' => 'pgsql:host=10.10.5.79;port=5432;dbname=runetid_dev',
      'username' => 'ruvents_beta',
      'password' => 'ieBoo3thooDaer2E',
      'emulatePrepare' => true,
      'charset' => 'utf8',
      'enableProfiling' => true,
      'enableParamLogging' => true,
      'schemaCachingDuration' => 600
  ];
}

