<?php

class UserQr extends AbstractCommand
{

  private static $secret = 'mzhVfrfUmw';

  /**
   * Основные действия комманды
   * @param int $rocId
   * @param string $hash
   * @return void
   */
  protected function doExecute($rocId = 0, $hash = '')
  {
//    if ($hash !== $this->getHash($rocId))
//    {
//      return;
//    }
    $path = Yii::app()->basePath . '/..' . $this->getPath($rocId);
    $fullPath = $path . '/' . $rocId . '.png';
    if (!file_exists($fullPath))
    {
      Yii::import('ext.qrcode.QRCode');
      $code = new QRCode($rocId);

      if (!file_exists($path))
      {
        mkdir($path, 0755, true);
      }
      $code->create($fullPath);
    }

    header('Content-type: image/png');
    echo file_get_contents($fullPath);
  }

  private function getPath($rocId)
  {
    $sub = intval($rocId / 10000);
    return '/data/qr/' . $sub;
  }

  private function getHash($rocId)
  {
    return substr(md5(self::$secret . $rocId), 0, 8);
  }
}
