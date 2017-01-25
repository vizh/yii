<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OrderId
 * @property int $OrderItemId
 *
 * @property Order $Order
 * @property OrderItem $OrderItem
 *
 * Описание вспомогательных методов
 * @method OrderLinkOrderItem   with($condition = '')
 * @method OrderLinkOrderItem   find($condition = '', $params = [])
 * @method OrderLinkOrderItem   findByPk($pk, $condition = '', $params = [])
 * @method OrderLinkOrderItem   findByAttributes($attributes, $condition = '', $params = [])
 * @method OrderLinkOrderItem[] findAll($condition = '', $params = [])
 * @method OrderLinkOrderItem[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method OrderLinkOrderItem byId(int $id, bool $useAnd = true)
 * @method OrderLinkOrderItem byOrderId(int $id, bool $useAnd = true)
 * @method OrderLinkOrderItem byOrderItemId(int $id, bool $useAnd = true)
 */
class OrderLinkOrderItem extends ActiveRecord
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
        return 'PayOrderLinkOrderItem';
    }

    public function relations()
    {
        return [
            'Order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId'],
            'OrderItem' => [self::BELONGS_TO, '\pay\models\OrderItem', 'OrderItemId'],
        ];
    }
}
