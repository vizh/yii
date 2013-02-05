<?php
namespace event\models;

class Logo
{
  private $idName;

  public function __construct($idName)
  {
    $this->idName = $idName;
  }

  /**
   * @param bool $serverPath
   * @return string
   */
  protected function getPath($serverPath = false)
  {
    $result = \Yii::app()->params['EventDir'];
    if ($serverPath)
    {
      $result = \Yii::getPathOfAlias('webroot') . $result;
    }
    return $result;
  }

  /**
   * @param bool $serverPath
   * @return string
   */
  public function getMini($serverPath = false)
  {
    $name = 'minilogo/event_' . $this->idName . '.png';
    if ($serverPath)
    {
      return $this->getPath($serverPath) . $name;
    }
    elseif (file_exists($this->getPath(true) . $name))
    {
      return $this->getPath($serverPath) . $name;
    }
    else
    {
      return $this->getNormal($serverPath);
    }
  }

  /**
   * @param bool $serverPath
   * @return string
   */
  public function getNormal($serverPath = false)
  {
    $name = 'logo/event_' . $this->idName . '.png';
    if ($serverPath)
    {
      return $this->getPath($serverPath) . $name;
    }
    elseif (file_exists($this->getPath(true) . $name))
    {
      return $this->getPath($serverPath) . $name;
    }
    else
    {
      return $this->getPath($serverPath) . 'none.png';
    }
  }

  public function getSquare70($serverPath = false)
  {
    $name = 'square70/event_'.$this->idName.'.jpg';
    if ($serverPath)
    {
      return $this->getPath($serverPath) . $name;
    }
    elseif (file_exists($this->getPath(true) . $name))
    {
      return $this->getPath($serverPath) . $name;
    }
    else
    {
      return $this->getNormal($serverPath);
    }
  }

  /**
   * @param bool $serverPath
   * @return string
   * @throws \application\components\Exception
   */
  public function getOriginal($serverPath = false)
  {
    throw new \application\components\Exception('Не реализован метод');
  }
}
