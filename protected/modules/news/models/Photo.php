<?php
namespace news\models;
class Photo 
{
  private $newsId;
  public function __construct($newsId)
  {
    $this->newsId = $newsId;
  }
  
  /**
   * @param bool $serverPath
   * @return string
   */
  protected function getPath($serverPath = false)
  {
    $folder = (int) ($this->newsId / 10000);
    $path = \Yii::app()->params['NewsPhotoDir'] . $folder . '/';
    if ($serverPath)
    {
      $path = \Yii::getPathOfAlias('webroot') . $path;
    }
    return $path;
  }
  
  protected function getByName($serverPath, $name, $noFile)
  {
    if ($serverPath || file_exists($this->getPath(true) . $name))
    {
      return $this->getPath($serverPath) . $name;
    }
    else
    {
      return $this->getPath($serverPath) . $noFile;
    }
  }
  
  /**
   * Возвращает путь к изображению новости шириной 140px
   * @param bool $serverPath
   * @return string
   */
  public function get140px($serverPath = false)
  {
    return $this->getByName($serverPath, ($this->newsId.'_140.jpg'), 'nophoto_140.png');
  }
  
  /**
   * Возвращает путь к исходному изображению новости
   * @param bool $serverPath
   * @return string
   */
  public function getOriginal($serverPath = false)
  {
    return $this->getByName($serverPath, ($this->newsId.'.jpg'), 'nophoto_200.png');
  }
  
  /**
   *
   * @param $image
   * @return void 
   */
  public function savePhoto($image)
  {
    $tmpName = DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR .
      md5('news' . microtime()) . '.jpg';
    file_put_contents($tmpName, $image);

    $path = $this->getPath(true);
    if (!is_dir($path))
    {
      mkdir($path);
    }

    $img = \application\components\graphics\Image::GetImage($tmpName);
    $origImage = $this->getOriginal(true);
    imagejpeg($img, $origImage, 100);
    imagedestroy($img);
    $newImage = $this->get140px(true);
    \application\components\graphics\Image::ResizeAndSave($origImage, $newImage, 140, 0, array('x1'=>0, 'y1'=>0));
  }
}