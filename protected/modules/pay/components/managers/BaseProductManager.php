<?php
namespace pay\components\managers;

use application\components\helpers\ArrayHelper;
use mail\components\Mail;
use mail\components\mailers\SESMailer;
use pay\components\CodeException;
use pay\components\Exception;
use pay\components\MessageException;
use pay\models\OrderItem;
use pay\models\Product;
use pay\models\ProductAttribute;
use user\models\User;
use Yii;

/**
 * Class BaseProductManager
 *
 * @property string $LinkProducts
 * @property int $Limit
 */
abstract class BaseProductManager
{
    // Product manager
    const EVENT = 'EventProductManager';
    const FOOD = 'FoodProductManager';
    const ROOM = 'RoomProductManager';

    /**
     * @var Product
     */
    protected $product;

    protected $isUniqueOrderItem = true;

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @abstract
     * @param User $user
     * @param array $params
     * @return bool
     */
    abstract public function checkProduct($user, $params = []);

    /**
     * Оформляет покупку продукта на пользователя
     * @abstract
     *
     * @param User $user
     * @param OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    abstract protected function internalBuy($user, $orderItem = null, $params = []);

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
     * @return Product
     */
    abstract public function getFilterProduct($params);

    /**
     * @abstract
     *
     * @param User $fromUser
     * @param User $toUser
     * @param array $params
     *
     * @return bool
     */
    abstract protected function internalChangeOwner($fromUser, $toUser, $params = []);

    /**
     * @param Product $product
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Возвращает список необходимых аттрибутов для Product
     * @return string[]
     */
    public function getProductAttributeNames()
    {
        return ['LinkProducts', 'Limit'];
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
     * Если у товара задано ограничение на кол-во продаж,
     * проверяется возможность покупки
     *
     * @return bool
     */
    public function checkLimit()
    {
        $limit = $this->getLimit();
        if ($limit !== null) {
            if ($this->getSoldCount() >= $limit) {
                return false;
            }
        }
        return true;
    }

    /**
     * Возвращает лимит на кол-во продаж продукта
     * @return int|null
     */
    public function getLimit()
    {
        if (isset($this->Limit)) {
            $limit = intval($this->Limit);
            if ($limit > 0) {
                return $limit;
            }
        }
        return null;
    }

    /**
     * Возвращает кол-во продаж продукта
     * @return int
     */
    public function getSoldCount()
    {
        return OrderItem::model()->byProductId($this->product->Id)->byPaid(true)->count();
    }

    /**
     * Magic method __get
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames())) {
            $attributes = $this->product->getProductAttributes();
            return isset($attributes[$name]) ? $attributes[$name]->Value : null;
        } else {
            return null;
        }
    }

    /**
     * Magic method __set
     * @param string $name
     * @param mixed $value
     * @throws MessageException
     */
    public function __set($name, $value)
    {
        if ($this->product->getIsNewRecord()) {
            throw new MessageException('Продукт еще не сохранен.');
        }

        if (in_array($name, $this->getProductAttributeNames())) {
            $attributes = $this->product->getProductAttributes();
            if (!isset($attributes[$name])) {
                $attribute = new ProductAttribute();
                $attribute->ProductId = $this->product->Id;
                $attribute->Name = $name;
                $this->product->setProductAttribute($attribute);
            } else {
                $attribute = $attributes[$name];
            }
            $attribute->Value = $value;
            $attribute->save();
        } else {
            throw new MessageException('Данный продукт не содержит аттрибута с именем '.$name);
        }
    }

    /**
     * Magic method __isset
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames())) {
            $attributes = $this->product->getProductAttributes();
            return isset($attributes[$name]);
        } else {
            return false;
        }
    }

    /**
     * @param OrderItem $orderItem
     * @return bool
     */
    public function rollback(OrderItem $orderItem)
    {
        if ($this->internalRollback($orderItem)) {
            $orderItem->refund();
            return true;
        }
        return false;
    }

    /**
     * @param OrderItem $orderItem
     * @throws MessageException
     * @return bool
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        throw new MessageException(Yii::t('app', 'Метод отката заказа не реализован для этого типа продукта'));
    }

    /**
     * @param User $payer
     * @param User $owner
     * @param string|null $bookTime
     * @param array $attributes
     * @return OrderItem
     * @throws Exception
     */
    public function createOrderItem(User $payer, User $owner, $bookTime = null, $attributes = [])
    {
        if (!$this->checkProduct($owner)) {
            throw new MessageException($this->getCheckProductMessage($owner), MessageException::ORDER_ITEM_GROUP_CODE);
        }

        if (!$this->checkLimit()) {
            throw new MessageException($this->getCheckLimitMessage($owner), MessageException::ORDER_ITEM_GROUP_CODE);
        }

        if ($this->isUniqueOrderItem) {
            $orderItem = OrderItem::model()
                ->byProductId($this->product->Id)
                ->byPayerId($payer->Id)
                ->byOwnerId($owner->Id)
                ->byDeleted(false)
                ->byPaid(false)
                ->find();

            if ($orderItem) {
                throw new CodeException(CodeException::ORDER_ITEM_EXISTS);
            }
        }

        foreach ($this->getRequiredOrderItemAttributeNames() as $key) {
            if (!isset($attributes[$key])) {
                throw new MessageException(
                    'Не задан обязательный параметр '.$key.' при добавлении заказа.',
                    MessageException::ORDER_ITEM_GROUP_CODE
                );
            }
        }

        $orderItem = new OrderItem();
        $orderItem->ProductId = $this->product->Id;
        $orderItem->PayerId = $payer->Id;
        $orderItem->OwnerId = $owner->Id;
        $orderItem->Booked = is_null($bookTime) ? null : date('Y-m-d H:i:s', time() + intval($bookTime));

        $orderItem->save();

        foreach ($this->getOrderItemAttributeNames() as $key) {
            if (isset($attributes[$key])) {
                $orderItem->setItemAttribute($key, $attributes[$key]);
            }
        }

        return $orderItem;
    }

    /**
     * @param OrderItem $orderItem
     * @return int
     */
    public function getPrice($orderItem)
    {
        return $this->getPriceByTime($orderItem->PaidTime);
    }

    /**
     * @param string $time
     * @return int
     * @throws Exception
     */
    public function getPriceByTime($time = null)
    {
        $time = $time ?: date('Y-m-d H:i:s', time());

        foreach ($this->product->Prices as $price) {
            if ($price->StartTime <= $time && ($price->EndTime == null || $time < $price->EndTime)) {
                return $price->Price;
            }
        }

        if ($_SERVER['REQUEST_URI'] === '/event/updatedusers/' || Yii::app()->controller->route == 'pay/admin/stats/index') {
            return 0;
        }

        throw new MessageException('Не удалось определить цену продукта!!');
    }

    /**
     * @param OrderItem $orderItem
     * @return string
     */
    public function getTitle($orderItem)
    {
        return !empty($this->product->OrderTitle) ? $this->product->OrderTitle : $this->product->Title;
    }

    /**
     * @param OrderItem $orderItem
     * @return int
     */
    public function getCount($orderItem)
    {
        return 1;
    }

    /**
     * @param User $fromUser
     * @param User $toUser
     * @param array $params
     *
     * @return bool
     */
    final public function changeOwner(User $fromUser, User $toUser, $params = [])
    {
        if (!$this->checkProduct($toUser, $params)) {
            return false;
        }
        return $this->internalChangeOwner($fromUser, $toUser, $params);
    }

    /**
     * Проверяет возможность покупки и оформляет покупку продукта на пользователя
     * @param User $user
     * @param OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    final public function buy($user, $orderItem = null, $params = [])
    {
        if (false === $this->checkProduct($user, $params)) {
            return false;
        }

        $success = $this->internalBuy($user, $orderItem, $params);

        if ($success) {
            $this->buyLinkProducts($user, $orderItem);
            $this->sendMail($user);
        }

        return $success;
    }

    /**
     * @param User $user
     * @param array $params
     *
     * @return string
     */
    protected function getCheckLimitMessage($user, $params = [])
    {
        return 'Данный товар не может быть приобретен. Превышен лимит допустимых продаж.';
    }

    /**
     * @param User $user
     * @param array $params
     *
     * @return string
     */
    protected function getCheckProductMessage($user, $params = [])
    {
        return 'Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар.';
    }

    /**
     * Отправляет письмо при покупке товара
     * @param $user
     * @return bool
     */
    private function sendMail($user)
    {
        $class = Yii::getExistClass('\pay\components\handlers\buyproduct\products', 'Product'.$this->product->Id, 'Base');
        $event = new \CModelEvent($this, ['owner' => $user, 'product' => $this->product]);

        /** @var Mail $mail */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();
    }

    /**
     * @param User $user
     * @param OrderItem $parentOrderItem
     */
    private function buyLinkProducts($user, $parentOrderItem)
    {
        if (!isset($this->LinkProducts) || $parentOrderItem->getIsNewRecord()) {
            return;
        }

        $selectedProducts = ArrayHelper::str2nums($parentOrderItem->getItemAttribute('SelectedLinkProducts'));
        foreach (ArrayHelper::str2nums($this->LinkProducts) as $id) {
            if (false === in_array($id, $selectedProducts)) {
                continue;
            }

            $product = Product::model()->byEventId($this->product->EventId)->findByPk($id);
            if ($product !== null) {
                try {
                    $orderItem = $product->getManager()->createOrderItem($parentOrderItem->Payer, $parentOrderItem->Owner);
                    $orderItem->activate();
                } catch (Exception $e) {
                }
            }
        }
    }
}
