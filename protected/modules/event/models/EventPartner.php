<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $CatalogCompanyId
 * @property int $TypeId
 * @property int $Order
 */
class EventPartner extends \CActiveRecord
{
  /**
   * @param string $className
   * @return EventPartner
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

    );
  }
}
