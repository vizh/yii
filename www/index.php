<?php
// отключаем отладку
$debug = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '82.142.129.35';
define('YII_DEBUG', $debug);
define('YII_TRACE_LEVEL',3);

$yii=dirname(__FILE__).'/../protected/Yii.php';

date_default_timezone_set('Europe/Moscow');
setlocale(LC_TIME, 'ru.UTF-8');


$config=dirname(__FILE__).'/../config/main.php';

//$data = require $config;

//var_dump($data);

require_once($yii);
$app = Yii::createWebApplication($config);
$app->run();


//  try
//  {
//
//    require_once '../library/AutoLoader.php';
//    AutoLoader::Init();
//    $config=dirname(__FILE__).'/../config/yiiconfig.php';
//    require_once($yii);
//    Yii::createWebApplication($config);
//    AutoLoader::Import('library.view.*');
//    AutoLoader::Import('library.widgets.*');
//    AutoLoader::Import('library.hooks.*');
//    AutoLoader::Import('library.rocid.search.*');
//    require_once 'bootstrap.php';
//    require_once 'lang/default.php';
//    FrontController::GetInstance()->Run();
//
//  }
//  catch (Exception $e)
//  {
//    processException($e);
//  }






/**
 * @param Exception $e
 */
function processException($e)
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