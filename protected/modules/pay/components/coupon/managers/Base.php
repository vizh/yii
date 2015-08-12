<?php
namespace pay\components\coupon\managers;

use pay\models\Coupon;
use pay\models\OrderItem;

/**
 * Class BaseManager
 * @package application\pay\components\coupon
 */
abstract class Base
{
    /** @var Coupon */
    protected $coupon;

    /**
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Описание типа скидки
     * @return string
     */
    abstract public function getDescription();

    /**
     * Описание типа скидки для клиентского интерфейса
     * @return string
     */
    abstract public function getClientDescription();

    /**
     * Вычисляет цену со скидкой
     * @param int $price
     * @return mixed
     */
    abstract public function calcDiscountPrice($price);

    /**
     * Примет скидку к заказу и возвращает стоимость заказа, с учетом этой скидки
     * @param OrderItem $orderItem
     * @return int
     */
    final public function apply(OrderItem $orderItem)
    {
        return $this->calcDiscountPrice($orderItem->getPrice());
    }

    /**
     * Возвращает текстовое представление скидки, например 10%, 100% или 200р.
     * @return string
     */
    abstract public function getDiscountString();
}