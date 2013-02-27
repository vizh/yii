<?php
namespace event\models\section;


/**
 * @property int $Id
 * @property int $SectionId
 * @property int $CompanyId
 * @property int $Order
 *
 * @property \catalog\models\Company $Company
 */
class Partner extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Partner
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionPartner';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
      'Company' => array(self::BELONGS_TO, '\catalog\models\Company', 'CompanyId')
    );
  }
}