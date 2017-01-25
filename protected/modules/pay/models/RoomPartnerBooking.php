<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OrderId
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
 * @property int $AdditionalCount
 * @property string $People
 * @property string $Car
 *
 * Описание вспомогательных методов
 * @method RoomPartnerBooking   with($condition = '')
 * @method RoomPartnerBooking   find($condition = '', $params = [])
 * @method RoomPartnerBooking   findByPk($pk, $condition = '', $params = [])
 * @method RoomPartnerBooking   findByAttributes($attributes, $condition = '', $params = [])
 * @method RoomPartnerBooking[] findAll($condition = '', $params = [])
 * @method RoomPartnerBooking[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method RoomPartnerBooking byId(int $id, bool $useAnd = true)
 * @method RoomPartnerBooking byOrderId(int $id, bool $useAnd = true)
 * @method RoomPartnerBooking byOwner(string $owner, bool $useAnd = true)
 * @method RoomPartnerBooking byProductId(int $id, bool $useAnd = true)
 * @method RoomPartnerBooking byPaid(bool $paid = true, bool $useAnd = true)
 * @method RoomPartnerBooking byDeleted(bool $deleted = true, bool $useAnd = true)
 *
 */
class RoomPartnerBooking extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return RoomPartnerBooking
     */
    public static function model($className = __CLASS__)
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
        if ($this->Paid || $this->Deleted) {
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