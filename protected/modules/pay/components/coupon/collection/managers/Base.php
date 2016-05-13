<?php
namespace pay\components\coupon\collection\managers;

use pay\components\CodeException;
use pay\components\OrderItemCollectable;
use pay\components\OrderItemCollection;
use pay\models\CollectionCoupon;
use pay\models\OrderItem;
use pay\models\Product;

/**
 * Class Base
 * @package pay\components\coupon\collection\managers
 *
 * @property string $Products
 */
abstract class Base
{
    /**
     * @var \pay\models\CollectionCoupon
     */
    protected $coupon;

    /**
     * @param \pay\models\CollectionCoupon $coupon
     */
    public function __construct(CollectionCoupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function __get($name)
    {
        if (!$this->coupon->getIsNewRecord() && in_array($name, $this->couponAttributeNames())) {
            $attributes = $this->coupon->getCouponAttributes();
            return isset($attributes[$name]) ? $attributes[$name]->Value : null;
        } else {
            return null;
        }
    }

    /**
     * Возвращает список доступных аттрибутов
     * @return string[]
     */
    protected function couponAttributeNames()
    {
        return [];
    }


    /**
     * @param Product $product
     * @return bool
     */
    public function checkCouponLinkProduct(Product $product) {
        foreach ($this->coupon->ProductLinks as $link) {
            if ($link->ProductId == $product->Id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Возвразает список уникальных id пользователей, которые присуствуют в счете
     * @param OrderItemCollection $collection
     * @return array
     */
    protected function getUniqueOwnerIdList(OrderItemCollection $collection)
    {
        $list = [];
        foreach ($collection as $item) {
            if ($this->checkCouponLinkProduct($item->getOrderItem()->Product)) {
                $list[] = $item->getOrderItem()->OwnerId;
            }
        }
        $list = array_unique($list);
        return $list;
    }

    /**
     * Применяет груповую скидку к заказам из колекции
     * @param OrderItemCollection $collection
     */
    public function apply(OrderItemCollection $collection)
    {
        $order = $collection->getOrder();

        $skip = !$order->PaidTime && $this->coupon->CreationTime <= $order->CreationTime ||
            $this->coupon->CreationTime <= $order->PaidTime;

        if (!$skip) {
            return;
        }

        $discount = $this->getDiscount($collection);
        if ($discount == 0) {
            return;
        }

        /** @var OrderItemCollectable $item */
        foreach ($collection as $item) {
            /** @var OrderItem $orderItem */
            $orderItem = $item->getOrderItem();
            if ($this->checkCouponLinkProduct($orderItem->Product)) {
                $item->setCollectionDiscount($discount);
            }
        }
    }

    /**
     * Возвращает сумму скидки, которая будет вычтена из стоимости каждого заказа
     * @param OrderItemCollection $collection
     * @return int
     */
    abstract public function getDiscount(OrderItemCollection $collection);
}