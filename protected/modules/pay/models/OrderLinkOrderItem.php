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
 */
class OrderLinkOrderItem extends ActiveRecord
{

    public function tableName()
    {
        return 'PayOrderLinkOrderItem';
    }

    public function relations()
    {
        return array(
            'Order' => array(self::BELONGS_TO, '\pay\models\Order', 'OrderId'),
            'OrderItem' => array(self::BELONGS_TO, '\pay\models\OrderItem', 'OrderItemId'),
        );
    }

    /**
     * @param int $orderId
     * @param bool $useAnd
     * @return OrderLinkOrderItem
     */
    public function byOrderId($orderId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."OrderId" = :OrderId';
        $criteria->params = ['OrderId' => $orderId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $orderItemId
     * @param bool $useAnd
     * @return OrderLinkOrderItem
     */
    public function byOrderItemId($orderItemId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."OrderItemId" = :OrderItemId';
        $criteria->params = ['OrderItemId' => $orderItemId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}
