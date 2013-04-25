<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Name
 * @property string $LogoUrl
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
    return 'JobCompany';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params['Name'] = $name;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
