<?php

class UserDm extends AbstractCommand
{

  private static $secret = 'mzhVfrfUmw';

  private $path;
  private $fullPath;

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
//      echo $this->getHash($rocId);
//      return;
//    }
    $this->path = Yii::app()->basePath . '/..' . $this->getPath($rocId);
    $this->fullPath = $this->path . '/' . $rocId . '.gif';
    if (!file_exists($this->fullPath))
    {
      $this->generateCode($rocId);
    }

    header('Content-type: image/png');
    echo file_get_contents($this->fullPath);
  }

  private function generateCode($rocId)
  {
    Yii::import('ext.qrcode.Barcode');

    if (!file_exists($this->path))
    {
      mkdir($this->path, 0755, true);
    }

    $x        = 100;  // barcode center
    $y        = 100;  // barcode center
    $height   = 50;   // barcode height in 1D ; module size in 2D
    $width    = 10;    // barcode height in 1D ; not use in 2D
    $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

    $code     = $rocId;
    $type     = 'datamatrix';

    $im     = imagecreatetruecolor(200, 200);
    $black  = ImageColorAllocate($im,0x00,0x00,0x00);
    $white  = ImageColorAllocate($im,0xff,0xff,0xff);
    imagefilledrectangle($im, 0, 0, 200, 200, $white);

    Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);

    imagegif($im, $this->fullPath);
    imagedestroy($im);
  }

  private function getPath($rocId)
  {
    $sub = intval($rocId / 10000);
    return '/data/dm/' . $sub;
  }

  private function getHash($rocId)
  {
    return substr(md5(self::$secret . $rocId), 0, 8);
  }
}