<?php
namespace pay\models;
use application\components\ActiveRecord;
use application\components\utility\Texts;
use pay\components\managers\BaseProductManager;

/**
 * Class FoodPartnerOrder
 * @package pay\models
 *
 * @property int $Id
 * @property string $Owner
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
 * @property int $EventId;
 * @property string $Number;
 * @property string $StatuteTitle
 * @property string $RealAddress
 * @property FoodPartnerOrderItem[] $Items
 *
 *
 * @method FoodPartnerOrder byEventId(int $eventId)
 * @method FoodPartnerOrder byPaid(bool $paid)
 * @method FoodPartnerOrder byDeleted(bool $deleted)
 */
class FoodPartnerOrder extends ActiveRecord
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

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayFoodPartnerOrder';
    }

    /**
     * @inheritdoc
     */
    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Items' => [self::HAS_MANY, '\pay\models\FoodPartnerOrderItem', 'OrderId']
        ];
    }

    private $total = null;

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        if ($this->total === null) {
            $this->total = 0;
            foreach ($this->Items as $item) {
                /** @var BaseProductManager $manager */
                $manager = $item->Product->getManager();
                $this->total += $manager->getPriceByTime($this->CreationTime) * $item->Count;
            }
        }
        return $this->total;
    }

    /**
     * Активирует счет на питание для партнеров
     * @return bool
     */
    public function activate()
    {
        if ($this->Deleted || $this->Paid)
            return false;

        $timestamp = date('Y-m-d H:i:s');
        foreach ($this->Items as $item) {
            $item->Paid = true;
            $item->PaidTime = $timestamp;
            $item->save();
        }

        $this->Paid = true;
        $this->PaidTime = $timestamp;
        $this->save();
        return true;
    }

    /**
     * Удаляет счет на питание для партнеров
     * @return bool|void
     */
    public function delete()
    {
        if ($this->Deleted || $this->Paid)
            return false;

        $timestamp = date('Y-m-d H:i:s');

        $this->Deleted = true;
        $this->DeletionTime = $timestamp;
        $this->save();
        foreach ($this->Items as $item) {
            $item->Deleted = true;
            $item->DeletionTime = $timestamp;
            $item->save();
        }
        return true;
    }


}