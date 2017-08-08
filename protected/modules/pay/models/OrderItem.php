<?php
namespace pay\models;

use application\components\ActiveRecord;
use Guzzle\Http\Client;
use partner\models\PartnerCallback;
use pay\components\Exception;
use pay\components\MessageException;
use user\models\User;

/**
 * @property int $Id
 * @property int $ProductId
 * @property int $PayerId
 * @property int $OwnerId
 * @property int $ChangedOwnerId
 * @property string $Booked
 * @property bool $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property string $UpdateTime
 * @property bool $Refund
 * @property string $RefundTime
 *
 * @property Product $Product
 * @property User $Payer
 * @property User $Owner
 * @property User $ChangedOwner
 * @property OrderLinkOrderItem[] $OrderLinks
 * @property CouponActivationLinkOrderItem $CouponActivationLink
 * @property OrderItemAttribute[] $Attributes
 *
 * Описание вспомогательных методов
 * @method OrderItem   with($condition = '')
 * @method OrderItem   find($condition = '', $params = [])
 * @method OrderItem   findByPk($pk, $condition = '', $params = [])
 * @method OrderItem   findByAttributes($attributes, $condition = '', $params = [])
 * @method OrderItem[] findAll($condition = '', $params = [])
 * @method OrderItem[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method OrderItem byId(int $id, bool $useAnd = true)
 * @method OrderItem byProductId(int $id, bool $useAnd = true)
 * @method OrderItem byPayerId(int $id, bool $useAnd = true)
 * @method OrderItem byOwnerId(int $id, bool $useAnd = true)
 * @method OrderItem byPaid(bool $paid = true, bool $useAnd = true)
 * @method OrderItem byDeleted(bool $deleted = true, bool $useAnd = true)
 * @method OrderItem byRefund(bool $refund = true, bool $useAnd = true)
 *
 * @method OrderLinkOrderItem[] OrderLinks($params)
 */
class OrderItem extends ActiveRecord
{
    /**
     * @var OrderItemAttribute[]
     */
    protected $orderItemAttributes;

    /**
     * @var CouponActivation
     */
    private $couponActivation;

    /**
     * @var bool
     */
    private $couponTrySet = false;

    private $loyaltyDiscount = false;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayOrderItem';
    }

    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, 'pay\models\Product', 'ProductId'],
            'Payer' => [self::BELONGS_TO, 'user\models\User', 'PayerId'],
            'Owner' => [self::BELONGS_TO, 'user\models\User', 'OwnerId'],
            'ChangedOwner' => [self::BELONGS_TO, 'user\models\User', 'ChangedOwnerId'],
            'OrderLinks' => [self::HAS_MANY, 'pay\models\OrderLinkOrderItem', 'OrderItemId'],
            'CouponActivationLink' => [self::HAS_ONE, 'pay\models\CouponActivationLinkOrderItem', 'OrderItemId'],
            'Attributes' => [self::HAS_MANY, 'pay\models\OrderItemAttribute', 'OrderItemId']
        ];
    }

    /**
     * @param $name
     *
     * @return null|string
     * @throws MessageException
     */
    public function getItemAttribute($name)
    {
        if ($this->getIsNewRecord()) {
            throw new MessageException('Заказ еще не сохранен.');
        }

        if (in_array($name, $this->Product->getManager()->getOrderItemAttributeNames()) === false) {
            throw new MessageException("Данный заказ не содержит аттрибута с именем $name");
        }

        $attributes = $this->getOrderItemAttributes();

        return isset($attributes[$name])
            ? $attributes[$name]->Value
            : null;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @throws MessageException
     */
    public function setItemAttribute($name, $value)
    {
        if ($this->getIsNewRecord()) {
            throw new MessageException('Заказ еще не сохранен.');
        }

        if (in_array($name, $this->Product->getManager()->getOrderItemAttributeNames())) {
            $attributes = $this->getOrderItemAttributes();
            if (!isset($attributes[$name])) {
                $attribute = new OrderItemAttribute();
                $attribute->OrderItemId = $this->Id;
                $attribute->Name = $name;
                $this->orderItemAttributes[$name] = $attribute;
            } else {
                $attribute = $attributes[$name];
            }
            $attribute->Value = $value;
            $attribute->save();
        } else {
            throw new MessageException('Данный заказ не содержит аттрибута с именем '.$name);
        }
    }

    /**
     * @return ProductAttribute[]
     */
    public function getOrderItemAttributes()
    {
        if ($this->orderItemAttributes === null) {
            $this->orderItemAttributes = [];
            foreach ($this->Attributes as $attribute) {
                $this->orderItemAttributes[$attribute->Name] = $attribute;
            }
        }

        return $this->orderItemAttributes;
    }

    /**
     * @param int|null $userId
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byChangedOwnerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($userId !== null) {
            $criteria->condition = '"t"."ChangedOwnerId" = :ChangedOwnerId';
            $criteria->params = ['ChangedOwnerId' => $userId];
        } else {
            $criteria->condition = '"t"."ChangedOwnerId" IS NULL';
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param $userId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byAnyOwnerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('("t"."OwnerId" = :OwnerId AND "t"."ChangedOwnerId" IS NULL) OR "t"."ChangedOwnerId" = :OwnerId');
        $criteria->params['OwnerId'] = $userId;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Product"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $criteria->with = ['Product'];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * Усли параметр $booked=true - добавляет условие, что срок заказа не истек
     *
     * @param $booked
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byBooked($booked = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($booked) {
            $criteria->condition = '"t"."Booked" IS NULL OR "t"."Booked" > :Booked';
        } else {
            $criteria->condition = '"t"."Booked" IS NOT NULL AND "t"."Booked" < :Booked';
        }

        $criteria->params = ['Booked' => date('Y-m-d H:i:s')];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @return CouponActivation
     */
    public function getCouponActivation()
    {
        if (!$this->Product->EnableCoupon && !$this->Paid) {
            return null;
        }

        if (is_null($this->couponActivation) && !$this->couponTrySet) {
            $this->couponTrySet = true;
            if (!$this->Paid) {
                /** @var $activation CouponActivation */
                $activation = CouponActivation::model()
                    ->byUserId($this->OwnerId)
                    ->byEventId($this->Product->EventId)
                    ->byEmptyLinkOrderItem()
                    ->find();

                if ($activation !== null) {
                    $rightProduct = $activation->Coupon->getIsForProduct($this->ProductId);
                    $rightTime = $this->PaidTime === null || $this->PaidTime >= $activation->CreationTime;
                    if ($rightProduct && $rightTime) {
                        $this->couponActivation = $activation;
                    }
                }
            } else {
                $this->couponActivation = $this->CouponActivationLink !== null ? $this->CouponActivationLink->CouponActivation : null;
            }
        }

        return $this->couponActivation;
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    public function activate($order = null)
    {
        $owner = $this->ChangedOwner !== null ? $this->ChangedOwner : $this->Owner;
        $result = $this->Product->getManager()->buy($owner, $this);
        $this->Paid = true;
        $this->PaidTime = ($order !== null ? $order->CreationTime : date('Y-m-d H:i:s'));
        $this->save();

        return $result;
    }

    /**
     * @return bool
     */
    public function check()
    {
        $owner = $this->ChangedOwnerId == null ? $this->Owner : $this->ChangedOwner;

        return $this->Product->getManager()->checkProduct($owner);
    }

    /**
     * Deactivates the order item
     */
    public function deactivate()
    {
        $this->Product->getManager()->rollback($this);
        $this->Paid = false;
        $this->PaidTime = null;
        $this->save();
    }

    /**
     * @param User $targetOwner
     *
     * @return bool
     */
    public function changeOwner(User $targetOwner)
    {
        $sourceOwner = empty($this->ChangedOwner)
            ? $this->Owner
            : $this->ChangedOwner;

        if ($this->Product->getManager()->changeOwner($sourceOwner, $targetOwner)) {
            $this->ChangedOwnerId = $targetOwner->Id;
            $this->save();

            PartnerCallback::onOrderItemRedirect($this->Product->Event, $this, $sourceOwner->RunetId);

            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->Product->getManager()->getPrice($this);
    }

    /**
     * Итоговое значение цены товара, с учетом скидки, если она есть
     *
     * @throws Exception
     * @return int|null
     */
    public function getPriceDiscount()
    {
        $prices[] = $this->getPrice();

        if ($prices[0] === null) {
            throw new MessageException('Не удалось определить цену продукта!');
        }

        if (!$this->Product->getIsTicket() && $this->Product->EnableCoupon) {
            $activation = $this->getCouponActivation();
            if ($activation) {
                $prices[] = $activation->Coupon->getManager()->apply($this);
            }

            if ($this->getLoyaltyDiscount()) {
                $prices[] = $this->getLoyaltyDiscount()->apply($this);
            }

            $discount = ReferralDiscount::findDiscount($this->Product, $this->Owner, $this->PaidTime);
            if ($discount) {
                $prices[] = $discount->apply($this);
            }
        }

        return (int)round(min($prices));
    }

    /**
     * @return Order
     */
    public function getPaidOrder()
    {
        if (!$this->Paid) {
            return null;
        }

        foreach ($this->OrderLinks as $link) {
            if ($link->Order && $link->Order->Paid) {
                return $link->Order;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }

    /**
     * Deletes the order item. It makes soft delete, that means the order item gets Deleted = TRUE and DeletionTime
     *
     * @return bool
     */
    public function delete()
    {
        if ($this->Paid || $this->Deleted) {
            return false;
        }

        /** @var $links OrderLinkOrderItem[] */
        $links = $this->OrderLinks(['with' => ['Order']]);
        foreach ($links as $link) {
            if (OrderType::getIsLong($link->Order->Type) && !$link->Order->Deleted) {
                return false;
            }
        }

        $this->Deleted = true;
        $this->DeletionTime = date('Y-m-d H:i:s');
        $this->save();

        return true;
    }

    /**
     * Отмечает возврат заказа.
     *
     * @return bool
     */
    public function refund()
    {
        if (!$this->Paid) {
            return false;
        }

        $time = date('Y-m-d H:i:s');

        $this->Refund = true;
        $this->RefundTime = $time;
        $this->Paid = false;

        /** @var OrderLinkOrderItem[] $links */
        $links = $this->OrderLinks(['with' => ['Order']]);
        foreach ($links as $link) {
            $order = $link->Order;
            if ($order->Paid) {
                $order->refund($this);
            }
        }

        $this->Deleted = true;
        $this->DeletionTime = $time;

        $this->save();

        return true;
    }

    /**
     * @return bool
     */
    public function deleteHard()
    {
        if ($this->Paid || $this->Deleted) {
            return false;
        }

        $this->Deleted = true;
        $this->DeletionTime = date('Y-m-d H:i:s');
        $this->save();

        return true;
    }

    /**
     *
     * @return int
     */
    public function clearBooked()
    {
        $db = \Yii::app()->getDb();
        $command = $db->createCommand();
        $count = $command->update(
            $this->tableName(),
            ['Deleted' => true],
            'Booked IS NOT NULL AND Booked < :Booked AND NOT Paid AND NOT Deleted',
            [':Booked' => date('Y-m-d H:i:s')]
        );

        return $count;
    }

    /**
     * @return null|LoyaltyProgramDiscount
     */
    public function getLoyaltyDiscount()
    {
        if ($this->loyaltyDiscount === false) {
            if ($this->Owner->hasLoyaltyDiscount()) {
                $paidTime = $this->PaidTime ?: date('Y-m-d H:i:s');
                $this->loyaltyDiscount = LoyaltyProgramDiscount::model()
                    ->byActual($paidTime)
                    ->byEventId($this->Product->EventId)
                    ->byProductId($this->ProductId)
                    ->find();
            } else {
                $this->loyaltyDiscount = null;
            }
        }

        return $this->loyaltyDiscount;
    }

    /**
     * @return User
     */
    public function getCurrentOwner()
    {
        return $this->ChangedOwner === null ? $this->Owner : $this->ChangedOwner;
    }
}
