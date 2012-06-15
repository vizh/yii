<?php

class GateChronoCallback extends AbstractCommand
{
  const PremiaCallback = 'http://bilety.premiaruneta.ru/system/remote/callback.php';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if ($_SERVER['REMOTE_ADDR'] !== '207.97.254.211')
    {
      header("Status: 500");
      exit;
    }
    try
    {
      $log = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'chrono.log';
      $fh = fopen($log, 'a') or die("can't open file");
      fwrite($fh, $_SERVER['QUERY_STRING'] . "\n");
      fclose($fh);

      $link = self::PremiaCallback . '?' . $_SERVER['QUERY_STRING'];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $link);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      if ($result === false)
      {
        header("Status: 500");
      }
      else
      {
        header("Status: 200 OK");
      }
    }
    catch (Exception $e)
    {
      header("Status: 500");
    }
  }
}
