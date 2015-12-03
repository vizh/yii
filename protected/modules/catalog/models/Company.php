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

  /**
   * @param bool $serverPath
   * @return string
   */
  public function getLogoForEvent($serverPath = false)
  {
    //todo: реализовать метод, сейчас только заглушка для страницы мероприятий
    return \Yii::app()->params['CatalogCompanyDir'] . $this->Id . '/100.png';
  }
}
