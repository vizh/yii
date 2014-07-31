<?php
namespace application\models;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property string $Description
 * @property strong $En
 */
class ProfessionalInterest extends \CActiveRecord
{
  /**
   * @param string $className
   * @return ProfessionalInterest
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ProfessionalInterest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }
  
  public function getOrderedList()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Title" ASC';
    return $this->findAll($criteria);
  }
}
