<?php
namespace pay\models;

/**
 * Class RoomPartnerOrder
 * @package pay\models
 *
 * @property int $Id
 * @property string $Name
 * @property string $Address
 * @property string $INN
 * @property string $KPP
 * @property string $BankName
 * @property string $Account
 * @property string $CorrespondentAccount
 * @property string $BIK
 * @property string $CreationTime
 * @property bool $Paid
 * @property string $PaidTime
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property string $ChiefName
 * @property string $ChiefPosition
 * @property string $ChiefNameP
 * @property string $ChiefPositionP
 *
 *
 * @property RoomPartnerBooking[] $Bookings
 */
class RoomPartnerOrder extends \CActiveRecord
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
    return 'PayRoomPartnerOrder';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Bookings' => [self::HAS_MANY, '\pay\models\RoomPartnerBooking', 'OrderId']
    ];
  }

  /**
   * @param bool $deleted
   * @param bool $useAnd
   * @return $this
   */
  public function byDeleted($deleted, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$deleted ? 'NOT ' : '' ) . '"t"."Deleted"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $paid
   * @param bool $useAnd
   * @return $this
   */
  public function byPaid($paid = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$paid ? 'NOT ' : '' ) . '"t"."Paid"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  private $total = null;
  /**
   * @return int
   */
  public function getTotalPrice()
  {
    if ($this->total == null)
    {
      $this->total = 0;
      foreach ($this->Bookings as $booking)
      {
        $manager = $booking->Product->getManager();
        $this->total += $manager->Price * $booking->getStayDay();
      }
    }
    return $this->total;
  }

  public function activate()
  {
    if ($this->Deleted || $this->Paid)
      return false;

    $timestamp = date('Y-m-d H:i:s');
    foreach ($this->Bookings as $booking)
    {
      $booking->Paid = true;
      $booking->PaidTime = $timestamp;
      $booking->save();
    }

    $this->Paid = true;
    $this->PaidTime = $timestamp;
    $this->save();
    return true;
  }

  public function delete()
  {
    if ($this->Deleted || $this->Paid)
      return false;

    $this->Deleted = true;
    $this->DeletionTime = date('Y-m-d H:i:s');
    $this->save();
    foreach ($this->Bookings as $booking)
    {
      $booking->OrderId = null;
      $booking->save();
    }
    return true;
  }


}