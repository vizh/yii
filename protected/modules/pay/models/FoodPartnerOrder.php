<?php
namespace pay\models;

use application\components\ActiveRecord;
use pay\components\managers\BaseProductManager;

/**
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
 * Описание вспомогательных методов
 * @method FoodPartnerOrder   with($condition = '')
 * @method FoodPartnerOrder   find($condition = '', $params = [])
 * @method FoodPartnerOrder   findByPk($pk, $condition = '', $params = [])
 * @method FoodPartnerOrder   findByAttributes($attributes, $condition = '', $params = [])
 * @method FoodPartnerOrder[] findAll($condition = '', $params = [])
 * @method FoodPartnerOrder[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method FoodPartnerOrder byId(int $id, bool $useAnd = true)
 * @method FoodPartnerOrder byEventId(int $id, bool $useAnd = true)
 * @method FoodPartnerOrder byPaid(bool $paid = true, bool $useAnd = true)
 * @method FoodPartnerOrder byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class FoodPartnerOrder extends ActiveRecord
{
    private $total = null;

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
        return 'PayFoodPartnerOrder';
    }

    public function relations()
    {
        return [
            'Items' => [self::HAS_MANY, '\pay\models\FoodPartnerOrderItem', 'OrderId']
        ];
    }

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
     *
     * @return bool
     */
    public function activate()
    {
        if ($this->Deleted || $this->Paid) {
            return false;
        }

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
     *
     * @return bool
     */
    public function delete()
    {
        if ($this->Deleted || $this->Paid) {
            return false;
        }

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