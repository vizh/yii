<?php
namespace pay\models;

use application\components\ActiveRecord;
use pay\components\MessageException;
use user\models\Referral;

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
 * @property boolean $Refund
 * @property string $RefundTime
 *
 * @property Product $Product
 * @property \user\models\User $Payer
 * @property \user\models\User $Owner
 * @property \user\models\User $ChangedOwner
 * @property OrderLinkOrderItem[] $OrderLinks
 * @property CouponActivationLinkOrderItem $CouponActivationLink
 * @property OrderItemAttribute[] $Attributes
 *
 * @method OrderItem findByPk()
 * @method OrderItem find()
 * @method OrderItem[] findAll()
 * @method OrderItem with()
 * @method OrderItem byRefund(boolean $refund)
 */
class OrderItem extends ActiveRecord
{
    /**
     * @static
     * @param string $className
     * @return OrderItem
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string
     */
    public function tableName()
    {
        return 'PayOrderItem';
    }

    /**
     * @return string
     */
    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId'),
            'Payer' => array(self::BELONGS_TO, '\user\models\User', 'PayerId'),
            'Owner' => array(self::BELONGS_TO, '\user\models\User', 'OwnerId'),
            'ChangedOwner' => array(self::BELONGS_TO, '\user\models\User', 'ChangedOwnerId'),
            'OrderLinks' => array(self::HAS_MANY, '\pay\models\OrderLinkOrderItem', 'OrderItemId'),
            'CouponActivationLink' => array(self::HAS_ONE, '\pay\models\CouponActivationLinkOrderItem', 'OrderItemId'),

            'Attributes' => array(self::HAS_MANY, '\pay\models\OrderItemAttribute', 'OrderItemId'),
        );
    }

    /**
     * @param $name
     * @return null|string
     * @throws MessageException
     */
    public function getItemAttribute($name)
    {
        if ($this->getIsNewRecord()) {
            throw new MessageException('Заказ еще не сохранен.');
        }
        if (in_array($name, $this->Product->getManager()->getOrderItemAttributeNames())) {
            $attributes = $this->getOrderItemAttributes();
            return isset($attributes[$name]) ? $attributes[$name]->Value : null;
        } else {
            throw new MessageException('Данный заказ не содержит аттрибута с именем ' . $name);
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws MessageException
     */
    public function setItemAttribute($name, $value)
    {
        if ($this->getIsNewRecord()){
            throw new MessageException('Заказ еще не сохранен.');
        }
        if (in_array($name, $this->Product->getManager()->getOrderItemAttributeNames())){
            $attributes = $this->getOrderItemAttributes();
            if (!isset($attributes[$name])){
                $attribute = new \pay\models\OrderItemAttribute();
                $attribute->OrderItemId = $this->Id;
                $attribute->Name = $name;
                $this->orderItemAttributes[$name] = $attribute;
            }
            else{
                $attribute = $attributes[$name];
            }
            $attribute->Value = $value;
            $attribute->save();
        }
        else
        {
            throw new MessageException('Данный заказ не содержит аттрибута с именем ' . $name);
        }
    }

    /** @var OrderItemAttribute[] */
    protected $orderItemAttributes = null;

    /**
     * @return ProductAttribute[]
     */
    public function getOrderItemAttributes()
    {
        if ($this->orderItemAttributes === null){
            $this->orderItemAttributes = array();
            foreach ($this->Attributes as $attribute){
                $this->orderItemAttributes[$attribute->Name] = $attribute;
            }
        }

        return $this->orderItemAttributes;
    }

    /**
     * @param int $productId
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byProductId($productId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ProductId" = :ProductId';
        $criteria->params = array('ProductId' => $productId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return OrderItem
     */
    public function byPayerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."PayerId" = :PayerId';
        $criteria->params = array('PayerId' => $userId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return OrderItem
     */
    public function byOwnerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."OwnerId" = :OwnerId';
        $criteria->params = array('OwnerId' => $userId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int|null $userId
     * @param bool $useAnd
     * @return OrderItem
     */
    public function byChangedOwnerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($userId !== null){
            $criteria->condition = '"t"."ChangedOwnerId" = :ChangedOwnerId';
            $criteria->params = array('ChangedOwnerId' => $userId);
        }
        else{
            $criteria->condition = '"t"."ChangedOwnerId" IS NULL';
        }
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byAnyOwnerId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('
      ("t"."OwnerId" = :OwnerId AND "t"."ChangedOwnerId" IS NULL) OR "t"."ChangedOwnerId" = :OwnerId'
        );
        $criteria->params['OwnerId'] = $userId;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return OrderItem
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Product"."EventId" = :EventId';
        $criteria->params = array('EventId' => $eventId);
        $criteria->with = array('Product');
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $paid
     * @param bool $useAnds
     * @return OrderItem
     */
    public function byPaid($paid, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($paid ? '' : 'NOT ') . '"t"."Paid"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $deleted
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byDeleted($deleted, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($deleted ? '' : 'NOT ') . '"t"."Deleted"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * Усли параметр $booked=true - добавляет условие, что срок заказа не истек
     * @param $booked
     * @param bool $useAnd
     *
     * @return OrderItem
     */
    public function byBooked($booked = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($booked){
            $criteria->condition = '"t"."Booked" IS NULL OR "t"."Booked" > :Booked';
        }
        else{
            $criteria->condition = '"t"."Booked" IS NOT NULL AND "t"."Booked" < :Booked';
        }
        $criteria->params = array('Booked' => date('Y-m-d H:i:s'));
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @var CouponActivation
     */
    private $couponActivation = null;
    /** @var bool */
    private $couponTrySet = false;
    /**
     * @return CouponActivation
     */
    public function getCouponActivation()
    {
        if (!$this->Product->EnableCoupon && !$this->Paid){
            return null;
        }
        if ($this->couponActivation === null && !$this->couponTrySet){
            $this->couponTrySet = true;
            if (!$this->Paid){
                /** @var $activation CouponActivation */
                $activation = CouponActivation::model()
                    ->byUserId($this->OwnerId)
                    ->byEventId($this->Product->EventId)
                    ->byEmptyLinkOrderItem()->find();
                if ($activation !== null){
                    $rightProduct = $activation->Coupon->getIsForProduct($this->ProductId);
                    $rightTime = $this->PaidTime === null || $this->PaidTime >= $activation->CreationTime;
                    if ($rightProduct && $rightTime){
                        $this->couponActivation = $activation;
                    }
                }
            }
            else{
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

    public function deactivate()
    {
        $this->Product->getManager()->rollback($this);
        $this->Paid = false;
        $this->PaidTime = null;
        $this->save();
    }

    /**
     * @param \user\models\User $newOwner
     *
     * @return bool
     */
    public function changeOwner(\user\models\User $newOwner)
    {
        $fromOwner = empty($this->ChangedOwner) ? $this->Owner : $this->ChangedOwner;
        if ($this->Product->getManager()->changeOwner($fromOwner, $newOwner)){
            $this->ChangedOwnerId = $newOwner->Id;
            $this->save();
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
     * @throws \pay\components\Exception
     * @return int|null
     */
    public function getPriceDiscount()
    {
        $prices[] = $this->getPrice();
        if ($prices[0] === null){
            throw new MessageException('Не удалось определить цену продукта!');
        }

        if (!$this->Product->getIsTicket() && $this->Product->EnableCoupon){
            $activation = $this->getCouponActivation();
            if ($activation !== null) {
                $prices[] = $activation->Coupon->getManager()->apply($this);
            }

            if ($this->getLoyaltyDiscount() !== null) {
                $prices[] = $this->getLoyaltyDiscount()->apply($this);
            }

            $discount = ReferralDiscount::findDiscount($this->Product, $this->Owner, $this->PaidTime);
            if ($discount !== null) {
                $prices[] = $discount->apply($this);
            }
        }
        $price = min($prices);
        return (int) round($price);
    }

    /**
     * @return Order
     */
    public function getPaidOrder()
    {
        if (!$this->Paid){
            return null;
        }
        foreach ($this->OrderLinks as $link){
            if ($link->Order->Paid){
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
     * @return bool
     */
    public function delete()
    {
        if ($this->Paid || $this->Deleted){
            return false;
        }

        /** @var $links OrderLinkOrderItem[] */
        $links = $this->OrderLinks(array('with' => array('Order')));
        foreach ($links as $link){
            if (OrderType::getIsLong($link->Order->Type) && !$link->Order->Deleted){
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
     * @return bool
     */
    public function refund()
    {
        if (!$this->Paid){
            return false;
        }

        $time = date('Y-m-d H:i:s');

        $this->Refund = true;
        $this->RefundTime = $time;
        $this->Paid = false;

        /** @var OrderLinkOrderItem[] $links */
        $links = $this->OrderLinks(['with' => ['Order']]);
        foreach ($links as $link){
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
        if ($this->Paid || $this->Deleted){
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
            array('Deleted' => true),
            'Booked IS NOT NULL AND Booked < :Booked AND NOT Paid AND NOT Deleted',
            array(':Booked' => date('Y-m-d H:i:s'))
        );
        return $count;
    }


    private $loyaltyDiscount = false;

    /**
     * @return null|LoyaltyProgramDiscount
     */
    public function getLoyaltyDiscount()
    {
        if ($this->loyaltyDiscount === false) {
            if ($this->Owner->hasLoyaltyDiscount()) {
                $paidTime = $this->PaidTime !== null ? $this->PaidTime : date('Y-m-d H:i:s');
                $this->loyaltyDiscount = LoyaltyProgramDiscount::model()
                    ->byActual($paidTime)->byEventId($this->Product->EventId)->byProductId($this->ProductId)->find();
            } else {
                $this->loyaltyDiscount = null;
            }
        }
        return $this->loyaltyDiscount;
    }

    /**
     * @return \user\models\User
     */
    public function getCurrentOwner()
    {
        return $this->ChangedOwner === null ? $this->Owner : $this->ChangedOwner;
    }
}
