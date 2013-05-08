<?php
namespace ruvents\components;

class QrCode
{
  public static function getAbsoluteUrl($user)
  {
    $data = '~RUNETID#'.$user->RunetId.'$';
    $path = '/files/ruvents/qrcode/'.$user->RunetId.'.png';
    if (!file_exists(\Yii::getPathOfAlias('webroot').$path))
    {
      $qrCode = new \ext\qrcode\QRcode($data, 'L');
      $qrCode->create(\Yii::getPathOfAlias('webroot').$path);
    }
    return 'http://'.RUNETID_HOST.$path;
  }
}
