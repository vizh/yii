<?php
namespace pay\components;

use pay\models\OrderItem;

class OrderItemCollectable
{
    /**
     * @var \pay\models\OrderItem
     */
    private $orderItem;

    /**
     * @var OrderItemCollection
     */
    private $collection;

    function __construct(OrderItem $orderItem, OrderItemCollection $collection)
    {
        $this->orderItem = $orderItem;
        $this->collection = $collection;
    }

    public function getOrderItem()
    {
        return $this->orderItem;
    }

    /**
     * Итоговое значение цены товара, с учетом скидки, если она есть
     * @throws MessageException
     * @return int|null
     */
    public function getPriceDiscount()
    {
        $price = $this->orderItem->getPriceDiscount();

        if ($price > ($this->getPrice() - $this->collectionDiscount)) {
            $price = $this->getPrice() - $this->collectionDiscount;
        }

        return $price;
    }

    /**
     * Размер скидки для заказа
     * @return int
     */
    public function getDiscount()
    {
        return $this->getPrice() - $this->getPriceDiscount();
    }

    /**
     * @var int
     */
    private $collectionDiscount = 0;

    /**
     * Устанавливает груповую скидку
     * @param int $discount
     */
    public function setCollectionDiscount($discount)
    {
        if ($this->collectionDiscount < $discount) {
            $this->collectionDiscount = $discount;
        }
    }

    private $isGroupDiscount = null;

    /**
     * @return bool|null
     */
    public function getIsGroupDiscount()
    {
        if ($this->isGroupDiscount === null) {
            $orderItem = $this->orderItem;
            if ($this->collectionDiscount > 0) {
                $this->isGroupDiscount = $orderItem->getPriceDiscount() > ($orderItem->getPrice() - $this->collectionDiscount);
            } else {
                $this->isGroupDiscount = false;
            }
        }
        return $this->isGroupDiscount;
    }

    private $price = null;

    /**
     * Стоимость заказа без учета скидок
     * @return int
     */
    protected function getPrice()
    {
        if ($this->price == null) {
            $this->price = $this->orderItem->getPrice();
        }
        return $this->price;
    }
}