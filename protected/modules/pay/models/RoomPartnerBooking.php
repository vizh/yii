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
 * @property int $OrderId
 * @property int $AdditionalCount
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
    return [
      'Order' => [self::BELONGS_TO, '\pay\models\RoomPartnerOrder', 'OrderId'],
      'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
    ];
  }

  /**
   * @param int $productId
   * @param bool $useAnd
   * @return $this
   */
  public function byProductId($productId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ProductId" = :ProductId';
    $criteria->params = ['ProductId' => $productId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }


  public function byDeleted($deleted, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$deleted ? 'NOT ' : '' ) . '"t"."Deleted"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $owner
   * @param bool $useAnd
   * @return $this
   */
  public function byOwner($owner, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Owner" = :Owner';
    $criteria->params = ['Owner' => $owner];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $hasOrder
   * @param bool $useAnd
   * @return $this
   */
  public function byHasOrder($hasOrder = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."OrderId" '.($hasOrder ? 'NOT' : '').' IS NULL';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function deleteHard()
  {
    if ($this->Paid || $this->Deleted)
    {
      return false;
    }

    $this->Deleted = true;
    $this->DeletionTime = date('Y-m-d H:i:s');
    $this->save();

    return true;
  }

  public function getStayDay()
  {
    return (strtotime($this->DateOut) - strtotime($this->DateIn)) / 60 / 60 / 24;
  }
}