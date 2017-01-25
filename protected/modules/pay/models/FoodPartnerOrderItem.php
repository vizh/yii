<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $OrderId
 * @property integer $ProductId
 * @property bool $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property integer $Count
 *
 * @property FoodPartnerOrder $Order
 * @property Product $Product
 *
 * Описание вспомогательных методов
 * @method FoodPartnerOrderItem   with($condition = '')
 * @method FoodPartnerOrderItem   find($condition = '', $params = [])
 * @method FoodPartnerOrderItem   findByPk($pk, $condition = '', $params = [])
 * @method FoodPartnerOrderItem   findByAttributes($attributes, $condition = '', $params = [])
 * @method FoodPartnerOrderItem[] findAll($condition = '', $params = [])
 * @method FoodPartnerOrderItem[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method FoodPartnerOrderItem byId(int $id, bool $useAnd = true)
 * @method FoodPartnerOrderItem byOrderId(int $id, bool $useAnd = true)
 * @method FoodPartnerOrderItem byProductId(int $id, bool $useAnd = true)
 * @method FoodPartnerOrderItem byPaid(bool $paid = true, bool $useAnd = true)
 * @method FoodPartnerOrderItem byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class FoodPartnerOrderItem extends ActiveRecord
{
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
        return 'PayFoodPartnerOrderItem';
    }

    public function relations()
    {
        return [
            'Order' => [self::BELONGS_TO, '\pay\models\FoodPartnerOrder', 'OrderId'],
            'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
        ];
    }
}