<?php
namespace catalog\models;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Url
 * @property string $CreationTime
 * @property string $UpdateTime
 */
class Company extends \CActiveRecord
{  
  /**
   * @param string $className
   * @return Company
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CatalogCompany';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }
  
  public function getLogos()
  {
    $logos = [];
    $contents = scandir($this->getDir(true), SCANDIR_SORT_ASCENDING);
    foreach ($contents as $content)
    {
      if (is_dir($this->getPath($content, true)))
      {
        $logos[] = new CompanyLogo($content, $this); 
      }
    }
    return $logos;
  }
    
  public function getPath($fileName = '', $absolute = false)
  {
    return $this->getDir($absolute).$fileName;
  }

  protected $fileDir;
  public function getDir($absolute = false)
  {
    if (!$this->fileDir) 
      $this->fileDir = sprintf(\Yii::app()->params['CatalogCompanyDir'], $this->Id);
    
    return ($absolute ? \Yii::getPathOfAlias('webroot') : '').$this->fileDir;
  }
}
