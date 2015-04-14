<?php
namespace pay\models;
use application\components\ActiveRecord;

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
 * @property string $People
 * @property string $Car
 *
 * @method RoomPartnerBooking byDeleted(boolean $deleted)
 * @method RoomPartnerBooking[] findAll()
 *
 * @method RoomPartnerBooking byProductId(int $productId)
 * @method RoomPartnerBooking byOwner(string $owner)
 *
 */
class RoomPartnerBooking extends ActiveRecord
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
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Product'];
        $criteria->condition = '"Product"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
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