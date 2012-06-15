<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 16.02.12
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */
class TestInnumbers extends GeneralCommand
{

  const CallbackUrl = 'http://in-numbers.ru/subscribe/callback.php';
  const PrivateKey = '586f5ab0e13a03127a0dfa3af3';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($rocid = '')
  {
//    $params = array();
//    $params['rocid'] = $rocid;
//    $params['key'] = self::PrivateKey;
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, self::CallbackUrl . '?' . http_build_query($params));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
//    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//    $result = curl_exec($ch);
//    curl_close($ch);
//    echo $result;
  }
}