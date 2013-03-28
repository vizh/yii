<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $SectionId
 * @property string $Name
 * @property string $Value
 *
 * @property Section $Section
 */
class Attribute extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Attribute
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionAttribute';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
    );
  }
  
  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params = array('Name' => $name);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function bySectionId($sectionId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."SectionId" = :SectionId';
    $criteria->params = array('SectionId' => $sectionId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
