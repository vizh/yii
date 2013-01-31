<?php
namespace tag\models;

/**
 * @property int $Id
 * @property string $Name
 * @property string $Title
 * @property bool $Verified
 */
class Tag extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Tag
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Tag';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }
}
