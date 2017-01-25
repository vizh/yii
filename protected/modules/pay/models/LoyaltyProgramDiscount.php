<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $ProductId
 * @property double $Discount
 * @property string $StartTime
 * @property string $EndTime
 * @property string $CreationTime
 *
 * @property Product $Product;
 *
 * Описание вспомогательных методов
 * @method LoyaltyProgramDiscount   with($condition = '')
 * @method LoyaltyProgramDiscount   find($condition = '', $params = [])
 * @method LoyaltyProgramDiscount   findByPk($pk, $condition = '', $params = [])
 * @method LoyaltyProgramDiscount   findByAttributes($attributes, $condition = '', $params = [])
 * @method LoyaltyProgramDiscount[] findAll($condition = '', $params = [])
 * @method LoyaltyProgramDiscount[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LoyaltyProgramDiscount byId(int $id, bool $useAnd = true)
 * @method LoyaltyProgramDiscount byEventId(int $id, bool $useAnd = true)
 */
class LoyaltyProgramDiscount extends ActiveRecord
{
    const StatusEnd = -1;
    const StatusActive = 1;
    const StatusSoon = 0;

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
        return 'PayLoyaltyProgramDiscount';
    }

    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
        ];
    }

    /**
     * @param int $productId
     * @param bool $useAnd
     * @return $this
     */
    public function byProductId($productId, $orIsNull = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ProductId" = :ProductId'.($orIsNull ? ' OR "t"."ProductId" IS NULL' : ''));
        $criteria->params['ProductId'] = $productId;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $time
     * @param bool $useAnd
     * @return $this
     */
    public function byActual($time, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."StartTime" IS NULL OR "t"."StartTime" <= :Time');
        $criteria->addCondition('"t"."EndTime" IS NULL OR "t"."EndTime" >= :Time');
        $criteria->params['Time'] = $time;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        $status = self::StatusSoon;
        $currentDate = date('Y-m-d H:i:s');
        if ($this->EndTime !== null && $this->EndTime < $currentDate) {
            $status = self::StatusEnd;
        } elseif (($this->StartTime == null || $this->StartTime < $currentDate) && ($this->EndTime == null || $this->EndTime > $currentDate)) {
            $status = self::StatusActive;
        }

        return $status;
    }

    /**
     * Примет скидку к заказу и возвращает стоимость заказа, с учетом этой скидки
     *
     * @param OrderItem $orderItem
     * @return int
     */
    public function apply(OrderItem $orderItem)
    {
        $price = $orderItem->getPrice();

        return $price - $price * $this->Discount / 100;
    }
}