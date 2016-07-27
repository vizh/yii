<?php

namespace pay\components\coupon\collection\managers;


use pay\components\OrderItemCollectable;
use pay\components\OrderItemCollection;
use pay\models\OrderItem;

/**
 * Class FirstNOrdersCountFix
 * @package pay\components\coupon\collection\managers
 *
 * @property int $Amount
 */
class FirstNOrdersCountFix extends CountFix
{
    public $count;

    /**
     * @inheritdoc
     */
    protected function couponAttributeNames()
    {
        return ['Amount'];
    }


    /**
     * @inheritdoc
     */
    public function getDiscount(OrderItemCollection $collection)
    {
        foreach ($this->coupon->ProductLinks as $link) {
            $this->count = OrderItem::model()->count('NOT "Deleted" AND NOT "Refund" AND "ProductId" = ' . $link->ProductId);
            if ($this->count < $this->Amount) {
                return $this->coupon->Discount;
            }
        }

        return 0;
    }

    /**
     * Применяет груповую скидку к заказам из колекции
     * @param OrderItemCollection $collection
     */
    public function apply(OrderItemCollection $collection)
    {
        $order = $collection->getOrder();

        if ($order && $this->coupon->CreationTime > $order->CreationTime) {
            return;
        }

        $discount = $this->getDiscount($collection);

        if ($discount == 0) {
            return;
        }
        $i = 0;
        /** @var OrderItemCollectable $item */
        foreach ($collection as $item) {
            /** @var OrderItem $orderItem */
            $orderItem = $item->getOrderItem();
            if ($this->checkCouponLinkProduct($orderItem->Product)) {
                $i++;
                if (($this->Amount - $this->count - $i) >= 0) {
                    $item->setCollectionDiscount($discount);
                }
            }
        }
    }
}
