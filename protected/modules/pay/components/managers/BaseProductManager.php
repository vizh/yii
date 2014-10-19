<?php
namespace pay\components\managers;

use pay\components\Exception;
use pay\components\MessageException;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;

abstract class BaseProductManager
{
    /**
     * @var \pay\models\Product
     */
    protected $product;

    protected $isUniqueOrderItem = true;

    /**
     * @param \pay\models\Product $product
     */
    public function __construct($product)
    {
        $this->product = $product;
    }


    public function __get($name)
    {
        if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames()))
        {
            $attributes = $this->product->getProductAttributes();
            return isset($attributes[$name]) ? $attributes[$name]->Value : null;
        }
        else
        {
            return null;
        }
    }

    public function __set($name, $value)
    {
        if ($this->product->getIsNewRecord()) {
            throw new MessageException('Продукт еще не сохранен.');
        }
        if (in_array($name, $this->getProductAttributeNames())) {
            $attributes = $this->product->getProductAttributes();
            if (!isset($attributes[$name])) {
                $attribute = new \pay\models\ProductAttribute();
                $attribute->ProductId = $this->product->Id;
                $attribute->Name = $name;
                $this->product->setProductAttribute($attribute);
            } else {
                $attribute = $attributes[$name];
            }
            $attribute->Value = $value;
            $attribute->save();
        } else {
            throw new MessageException('Данный продукт не содержит аттрибута с именем ' . $name);
        }
    }

    public function __isset($name)
    {
        if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames()))
        {
            $attributes = $this->product->getProductAttributes();
            return isset($attributes[$name]);
        }
        else
        {
            return false;
        }
    }

    /**
     * Возвращает список необходимых аттрибутов для Product
     * @return string[]
     */
    public function getProductAttributeNames()
    {
        return ['LinkProducts'];
    }


    /**
     * @return string[]
     */
    public function getRequiredProductAttributeNames()
    {
        return [];
    }

    /**
     * Возвращает список необходимых аттрибутов для OrderItem
     * @return string[]
     */
    public function getOrderItemAttributeNames()
    {
        return ['SelectedLinkProducts'];
    }

    /**
     * Возвращает список обязательных аттрибутов для OrderItem
     * @return string[]
     */
    public function getRequiredOrderItemAttributeNames()
    {
        return [];
    }

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @abstract
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    abstract public function checkProduct($user, $params = []);

    /**
     * @param \user\models\User $user
     * @param array $params
     *
     * @return string
     */
    protected function getCheckProductMessage($user, $params = [])
    {
        return 'Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар.';
    }

    /**
     * Проверяет возможность покупки и оформляет покупку продукта на пользователя
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    final public function buy($user, $orderItem = null, $params = array())
    {
        if (!$this->checkProduct($user, $params)) {
            return false;
        }
        $result = $this->internalBuy($user, $orderItem, $params);
        if ($result) {
            $this->buyLinkProducts($user, $orderItem);
        }
        return $result;
    }

    /**
     * @param User $user
     * @param OrderItem $parentOrderItem
     */
    private function buyLinkProducts($user, $parentOrderItem)
    {
        if (isset($this->LinkProducts) && !$parentOrderItem->getIsNewRecord() && $parentOrderItem->getItemAttribute('SelectedLinkProducts') !== null) {
            $productIdList = explode(',',$this->LinkProducts);
            $selectedProductIdList = explode(',', $parentOrderItem->getItemAttribute('SelectedLinkProducts'));
            foreach (array_intersect($selectedProductIdList, $productIdList) as $productId) {
                $product = Product::model()->findByPk($productId);
                if ($product !== null) {
                    try {
                        $orderItem = $product->getManager()->createOrderItem($parentOrderItem->Payer, $parentOrderItem->Owner);
                        $orderItem->activate();
                    } catch (Exception $e) {}
                }
            }
        }
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @abstract
     *
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    abstract protected function internalBuy($user, $orderItem = null, $params = array());

    /**
     * @param OrderItem $orderItem
     * @return bool
     */
    public function rollback(OrderItem $orderItem)
    {
        return $this->internalRollback($orderItem);
    }

    /**
     * Отменяет покупку по соответствующему заказу
     * @abstract
     * @param OrderItem $orderItem
     * @return bool
     */
    abstract protected function internalRollback(OrderItem $orderItem);

    /**
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    final public function changeOwner(\user\models\User $fromUser, \user\models\User $toUser, $params = array())
    {
        if (!$this->checkProduct($toUser, $params))
        {
            return false;
        }
        return $this->internalChangeOwner($fromUser, $toUser, $params);
    }

    /**
     * @abstract
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    abstract protected function internalChangeOwner($fromUser, $toUser, $params = array());

    /**
     * @param \user\models\User $payer
     * @param \user\models\User $owner
     * @param string|null $bookTime
     * @param array $attributes
     *
     * @return \pay\models\OrderItem
     * @throws \pay\components\Exception
     */
    public function createOrderItem(\user\models\User $payer, \user\models\User $owner, $bookTime = null, $attributes = array())
    {
        if (!$this->checkProduct($owner)) {
            throw new MessageException($this->getCheckProductMessage($owner), MessageException::ORDER_ITEM_GROUP_CODE);
        }

        if ($this->isUniqueOrderItem) {
            $orderItem = \pay\models\OrderItem::model()->byProductId($this->product->Id)
                ->byPayerId($payer->Id)->byOwnerId($owner->Id)
                ->byDeleted(false)->byPaid(false)->find();
            if ($orderItem !== null) {
                throw new MessageException('Вы уже заказали этот товар', MessageException::ORDER_ITEM_GROUP_CODE);
            }
        }


        foreach ($this->getRequiredOrderItemAttributeNames() as $key)
        {
            if (!isset($attributes[$key])) {
                throw new MessageException('Не задан обязательный параметр ' . $key . ' при добавлении заказа.', MessageException::ORDER_ITEM_GROUP_CODE);
            }
        }

        $orderItem = new \pay\models\OrderItem();
        $orderItem->ProductId = $this->product->Id;
        $orderItem->PayerId = $payer->Id;
        $orderItem->OwnerId = $owner->Id;
        $orderItem->Booked = $bookTime === null ? null : date('Y-m-d H:i:s', time() + intval($bookTime));
        $orderItem->save();

        foreach ($this->getOrderItemAttributeNames() as $key)
        {
            if (isset($attributes[$key])) {
                $orderItem->setItemAttribute($key, $attributes[$key]);
            }
        }

        return $orderItem;
    }

    /**
     * @abstract
     * @param array $params
     * @param string $filter
     * @return array
     */
    abstract public function filter($params, $filter);

    /**
     * @abstract
     * @param array $params
     * @return \pay\models\Product
     */
    abstract public function getFilterProduct($params);

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return int
     */
    public function getPrice($orderItem)
    {
        return $this->getPriceByTime($orderItem->PaidTime);
    }

    /**
     * @param string $time
     * @return int
     * @throws \pay\components\Exception
     */
    public function getPriceByTime($time = null)
    {
        $time = $time === null ? date('Y-m-d H:i:s', time()) : $time;
        foreach ($this->product->Prices as $price)
        {
            if ($price->StartTime <= $time && ($price->EndTime == null || $time < $price->EndTime))
            {
                return $price->Price;
            }
        }
        throw new MessageException('Не удалось определить цену продукта!');
    }

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return string
     */
    public function getTitle($orderItem)
    {
        return !empty($this->product->OrderTitle) ? $this->product->OrderTitle : $this->product->Title;
    }

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return int
     */
    public function getCount($orderItem)
    {
        return 1;
    }
}