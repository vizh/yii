<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 05.09.11
 * Time: 20:45
 * To change this template use File | Settings | File Templates.
 */
 
class ConvertPhoto extends AdminCommand
{
  public static $StartPath = '';
  public static $sizes = array('50', '90', '200', 'clear', '');
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
//    $file404 = $_SERVER['DOCUMENT_ROOT'] . '/files/photo/404.php';
//    unlink($file404);
//    self::$StartPath = $_SERVER['DOCUMENT_ROOT'] . '/files/photo';
//    $start = 0;
//    $end = 1;
//    set_time_limit(1000);
//    for ($i = $start; $i < $end; $i++)
//    {
//      foreach (self::$sizes  as $size)
//      {
//        $fromPath = $this->getFileName($i, $size);
//        if (file_exists($fromPath))
//        {
//          rename($fromPath, $this->getToFileName($i, $size));
//        }
//      }
//    }
    echo 'Success!!!!';
  }

  private function getFileName($i, $size)
  {
    return self::$StartPath . DIRECTORY_SEPARATOR . $i . ( !empty($size) ? '_' : '' ). $size . '.jpg';
  }

  private function getToFileName($i, $size)
  {
    $dir = (int) ($i / 10000);
    return self::$StartPath . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $i . ( !empty($size) ? '_' : '' ) . $size . '.jpg';
  }
}
