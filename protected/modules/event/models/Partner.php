<?php
namespace event\models;

use catalog\models\Company;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $CompanyId
 * @property int $TypeId
 * @property int $Order
 *
 * @property Company $Company
 * @property PartnerType $Type
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
    return 'EventPartner';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Company' => array(self::BELONGS_TO, '\catalog\models\Company', 'CompanyId'),
      'Type' => array(self::BELONGS_TO, '\event\models\PartnerType', 'TypeId')
    );
  }
}