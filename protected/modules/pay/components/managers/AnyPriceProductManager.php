<?php
namespace pay\components\managers;

use string;

class AnyPriceProductManager extends BaseProductManager
{
    /**
     * Возвращает список необходимых аттрибутов для OrderItem
     * @return string[]
     */
    public function getOrderItemAttributeNames()
    {
        return array_merge(['Price'], parent::getOrderItemAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredOrderItemAttributeNames()
    {
        return ['Price'];
    }


    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function checkProduct($user, $params = array())
    {
        return true;
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function internalBuyProduct($user, $orderItem = null, $params = array())
    {
        return true;
    }

    /**
     * @param array $params
     * @param string $filter
     * @return array
     */
    public function filter($params, $filter)
    {
        return array();
    }

    /**
     * @param array $params
     * @return \pay\models\Product
     */
    public function getFilterProduct($params)
    {
        return $this->product;
    }

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return int
     */
    public function getPrice($orderItem)
    {
        $price = (int)$orderItem->getItemAttribute('Price');
        return parent::getPrice($orderItem) * $price;
    }

    /**
     * Отменяет покупку продукта на пользовтеля
     * @param \user\models\User $user
     * @return bool
     */
    public function rollbackProduct($user)
    {

    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    public function internalChangeOwner($fromUser, $toUser, $params = array())
    {

    }
}