<?php
namespace pay\models;

use application\components\ActiveRecord;
use application\components\utility\Texts;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Number
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
 * @property string $StatuteTitle
 * @property string $RealAddress
 *
 * @property RoomPartnerBooking[] $Bookings
 *
 * Описание вспомогательных методов
 * @method RoomPartnerOrder   with($condition = '')
 * @method RoomPartnerOrder   find($condition = '', $params = [])
 * @method RoomPartnerOrder   findByPk($pk, $condition = '', $params = [])
 * @method RoomPartnerOrder   findByAttributes($attributes, $condition = '', $params = [])
 * @method RoomPartnerOrder[] findAll($condition = '', $params = [])
 * @method RoomPartnerOrder[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method RoomPartnerOrder byId(int $id, bool $useAnd = true)
 * @method RoomPartnerOrder byEventId(int $id, bool $useAnd = true)
 * @method RoomPartnerOrder byPaid(bool $paid = true, bool $useAnd = true)
 * @method RoomPartnerOrder byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class RoomPartnerOrder extends ActiveRecord
{
    private $total;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayRoomPartnerOrder';
    }

    public function relations()
    {
        return [
            'Bookings' => [self::HAS_MANY, '\pay\models\RoomPartnerBooking', 'OrderId']
        ];
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        if ($this->total == null) {
            $this->total = 0;
            foreach ($this->Bookings as $booking) {
                $manager = $booking->Product->getManager();
                $price = Texts::getOnlyNumbers($manager->Price) + $booking->AdditionalCount * $manager->AdditionalPrice;
                $this->total += $booking->getStayDay() * $price;
            }
        }

        return $this->total;
    }

    public function activate()
    {
        if ($this->Deleted || $this->Paid) {
            return false;
        }

        $timestamp = date('Y-m-d H:i:s');
        foreach ($this->Bookings as $booking) {
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
        if ($this->Deleted || $this->Paid) {
            return false;
        }

        $this->Deleted = true;
        $this->DeletionTime = date('Y-m-d H:i:s');
        $this->save();
        foreach ($this->Bookings as $booking) {
            $booking->OrderId = null;
            $booking->save();
        }

        return true;
    }

}