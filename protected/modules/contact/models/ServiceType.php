<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Pattern
 * @property string $UrlMask
 * @property bool $Visible
 */
class ServiceType extends \CActiveRecord
{
  /**
   * @param string $className
   * @return ServiceType
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactServiceType';
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
   * @param bool $visible
   * @param bool $useAnd
   * @return $this
   */
  public function byVisible($visible = true, $useAnd = true)
  {
    $critetia = new \CDbCriteria();
    $critetia->condition = (!$visible ? 'NOT ' : '').'"t"."Visible"';
    $this->getDbCriteria()->mergeWith($critetia,$useAnd);
    return $this;
  }
}