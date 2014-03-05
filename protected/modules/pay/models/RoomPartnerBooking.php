<?php
namespace pay\models;

/**
 * Class RoomPartnerBooking
 * @package pay\models
 *
 * @property int $Id
 * @property int $ProductId
 * @property string $Owner
 * @property string $DateIn
 * @property string $DateOut
 * @property bool $ShowPrice
 * @property bool $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 *
 */
class RoomPartnerBooking extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return RoomPartnerBooking
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayRoomPartnerBooking';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [];
  }
}