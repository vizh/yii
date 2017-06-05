<?php
namespace pay\components\managers;

use pay\components\MessageException;
use pay\models\OrderItem;

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
    public function checkProduct($user, $params = [])
    {
        return true;
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function internalBuy($user, $orderItem = null, $params = [])
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
        return [];
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
     * @param OrderItem $orderItem
     * @throws MessageException
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        throw new MessageException(\Yii::t('app', 'Метод отката заказа не реализован для этого типа продукта'));
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    public function internalChangeOwner($fromUser, $toUser, $params = [])
    {
    }
}