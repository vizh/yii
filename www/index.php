<?php
define('SCRIPT_BEGIN_TIME', microtime(true));

// отключаем отладку
define('YII_DEBUG', true);

//устанавливаем основной хост
define('ROCID_HOST', 'beta.rocid');

/** Блок запуска приложения */
require_once '../library/AutoLoader.php';
AutoLoader::Init();

$yii=dirname(__FILE__).'/../library/framework/yii.php';
$config=dirname(__FILE__).'/config/yiiconfig.php';

require_once($yii);
Yii::createWebApplication($config);

Timer::StartTimer();

AutoLoader::Import('library.view.*');
AutoLoader::Import('library.widgets.*');
AutoLoader::Import('library.hooks.*');
AutoLoader::Import('library.rocid.search.*');


if (!extension_loaded('pdo') and !dl('pdo.so')) die("NO pdo HERE!");
if (!extension_loaded('pdo_mysql') and !dl('pdo_mysql.so')) die("NO pdo_mysql HERE!");
//if (!extension_loaded('memcache') and !dl('memcache.so')) die("NO memcache HERE!");


require_once 'bootstrap.php';
require_once 'lang/default.php';
$frontController = FrontController::GetInstance();

try
{
  $frontController->Run();
}
catch(Exception $e)
{
  Yii::log('Message: ' . $e->getMessage() . "\n\n" . 'Trace string: ' . "\n" .
           $e->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');

  $logger = Yii::GetLogger();
  $logs = $logger->getLogs(CLogger::LEVEL_ERROR);//('', 'system.db.CDbCommand');
  ob_start();
  echo '<pre>';
  print_r($logs);
  print_r($_REQUEST);
  $logs = $logger->getProfilingResults();
  print_r($logs);
  echo '</pre>';
  $log = ob_get_clean();

  if (stristr($_SERVER['HTTP_HOST'], 'beta.rocid') !== false || stristr($_SERVER['HTTP_HOST'], 'pay.beta.rocid') !== false)
  {
    echo $log;
  }
  else
  {
    AutoLoader::Import('library.mail.*');

    $mail = new PHPMailer(false);
    $mail->AddAddress('nikitin@internetmediaholding.com');
    $mail->SetFrom('error@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $subject = 'Error! ' . $_SERVER['REQUEST_URI'] . date('d.m.Y');
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($log);
    $mail->Send();

    Lib::Redirect('/error/404/');
  }
}