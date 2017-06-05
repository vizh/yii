<?php
namespace pay\components\coupon\collection\managers;

use pay\components\OrderItemCollectable;
use pay\components\OrderItemCollection;

/**
 * Class Count
 * @package pay\components\collection\coupons
 *
 * @property int $Minimum
 * @property string $Products
 */
class Count extends Base
{
    /**
     * @inheritdoc
     */
    protected function couponAttributeNames()
    {
        return ['Minimum'];
    }

    /**
     * Возвращает минимальную стоимость в заказе
     * @param OrderItemCollection $collection
     * @return int
     */
    protected function getMinPrice(OrderItemCollection $collection)
    {
        $min = null;
        /** @var OrderItemCollectable $item */
        foreach ($collection as $item) {
            if (!$this->checkCouponLinkProduct($item->getOrderItem()->Product)) {
                continue;
            }

            if ($min === null || $item->getOrderItem()->getPrice() < $min) {
                $min = $item->getOrderItem()->getPrice();
            }
        }

        return $min;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(OrderItemCollection $collection)
    {
        $count = count($this->getUniqueOwnerIdList($collection));
        if ($count >= $this->Minimum) {
            return $this->getMinPrice($collection) / 100 * $this->coupon->Discount;
        }

        return 0;
    }
}
