<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Code
 * @property float $Discount
 * @property bool $Multiple
 * @property int $MultipleCount
 * @property string $Recipient
 * @property string $CreationTime
 * @property string $EndTime
 * @property bool $IsTicket
 * @property int $OwnerId
 *
 * @property CouponActivation[] $Activations
 * @property \user\models\User $Owner
 * @property CouponLinkProduct[] $ProductLinks
 * @property Product[] $Products
 *
 * @method \pay\models\Coupon find($condition='',$params=array())
 * @method \pay\models\Coupon findByPk($pk,$condition='',$params=array())
 * @method \pay\models\Coupon[] findAll($condition='',$params=array())
 */
class Coupon extends \CActiveRecord
{
    const MaxDelta = 0.001;

    /**
     * @param string $className
     *
     * @return Coupon
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayCoupon';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Activations' => [self::HAS_MANY, '\pay\models\CouponActivation', 'CouponId'],
            'Owner' => [self::BELONGS_TO, '\user\models\User', 'OwnerId'],
            'ProductLinks' => [self::HAS_MANY, '\pay\models\CouponLinkProduct', 'CouponId'],
            'Products' => [self::HAS_MANY, '\pay\models\Product', ['ProductId' => 'Id'], 'through' => 'ProductLinks']
        ];
    }

    public function __get($name)
    {
        if ($name === 'Discount') {
            return (float)parent::__get($name);
        }
        return parent::__get($name);
    }


    /**
     * @param string $code
     * @param bool $useAnd
     *
     * @return Coupon
     */
    public function byCode($code, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Code" = :Code';
        $criteria->params = array('Code' => $code);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     *
     * @return Coupon
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Activations"."UserId" = :UserId';
        $criteria->params = array('UserId' => $userId);
        $criteria->with = array('Activations' => array('together' => true));
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return Coupon
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = array('EventId' => $eventId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $isTicket
     * @param bool $useAnd
     * @return $this
     */
    public function byIsTicket($isTicket = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$isTicket ? 'NOT ' : '').'"t"."IsTicket"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function getIsRightCountActivations()
    {
        if ($this->Multiple)
        {
            return $this->MultipleCount === null || $this->MultipleCount > sizeof($this->Activations);
        }
        else
        {
            return sizeof($this->Activations) == 0;
        }
    }

    public function getIsNotExpired()
    {
        $time = date('Y-m-d H:i:s');
        return $this->EndTime === null || $this->EndTime > $time;
    }

    public function getIsForProduct($productId, $strict = false)
    {
        if (empty($this->ProductLinks) && !$strict)
            return true;

        foreach ($this->ProductLinks as $link) {
            if ($link->ProductId == $productId)
                return true;
        }
        return false;
    }

    /**
     * @param Product[] $products
     */
    public function addProductLinks($products)
    {
        foreach ($products as $product) {
            $link = new CouponLinkProduct();
            $link->CouponId = $this->Id;
            $link->ProductId = $product->Id;
            $link->save();
        }
    }


    /**
     * @param \user\models\User $payer
     * @param \user\models\User $owner
     *
     * @throws \pay\components\Exception
     * @return void
     */
    public function activate($payer, $owner)
    {
        $this->check();

        if (abs($this->Discount - 1.00) < self::MaxDelta) {
            if (count($this->Products) != 1)
                throw new \pay\components\Exception(\Yii::t('app','Для промо кода со скидкой 100% не указан товар, на который распространяется скидка, или указано больше одного товара.'), 303);

            $product = $this->Products[0];

            $item = OrderItem::model()
                ->byProductId($product->Id)
                ->byPayerId($payer->Id)->byOwnerId($owner->Id)
                ->byDeleted(false)->find();
            if ($item === null) {
                $item = new OrderItem();
                $item->ProductId = $product->Id;
                $item->PayerId = $payer->Id;
                $item->OwnerId = $owner->Id;
            }
            if ($item->activate()) {
                $activation = $this->createActivation($owner);

                $link = new CouponActivationLinkOrderItem();
                $link->CouponActivationId= $activation->Id;
                $link->OrderItemId = $item->Id;
                $link->save();
            } else {
                throw new \pay\components\Exception(\Yii::t('app','Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар'), 304);
            }
        } else {
            $this->processOldActivations($owner);
            $this->createActivation($owner);
        }
    }

    /**
     * @throws \pay\components\Exception
     */
    public function check()
    {
        if (!$this->getIsNotExpired())
        {
            throw new \pay\components\Exception(\Yii::t('app','Срок действия вашего промо кода истек'), 305);
        }
        if (!$this->getIsRightCountActivations())
        {
            throw new \pay\components\Exception(\Yii::t('app','Превышено максимальное количество активаций промо кода'), 301);
        }
    }

    /**
     * @param \user\models\User $owner
     *
     * @throws \pay\components\Exception
     */
    protected function processOldActivations($owner)
    {
        /** @var $activation CouponActivation */
        $activation = CouponActivation::model()
            ->byUserId($owner->Id)
            ->byEventId($this->EventId)
            ->byEmptyLinkOrderItem()->find();

        if ($activation !== null) {
            if ($activation->Coupon->contains($this)) {
                throw new \pay\components\Exception(\Yii::t('app', 'У пользователя уже активирован промо код с большей скидкой'), 302);
            } else {
                $activation->delete();
            }
        }
    }


    /**
     * Промо код А содержит промо код Б, если множество товаров А содержит множество товаров Б,
     * и скидка промо кода А, больше либо равна скидки промо кода Б.
     * @param Coupon $coupon
     * @return boolean
     */
    public function contains(Coupon $coupon)
    {
        if (empty($this->Products))
            return $this->compare($coupon) >= 0;
        if (empty($coupon->Products))
            return true;
        foreach ($coupon->Products as $product1) {
            $hasPair = false;
            foreach ($this->Products as $product2) {
                if ($product1->Id == $product2->Id) {
                    $hasPair = true;
                    continue;
                }
            }
            if (!$hasPair) {
                return false;
            }
        }
        return $this->compare($coupon) >= 0;
    }

    /**
     * Возвращает:
     * 0 - если размер скидки одинаковый,
     * 1 - если размер скидки объекта больше чем размер скидки аргумента,
     * -1 - если размер скидки аргумента больше чем размер скидки объекта.
     * @param Coupon $coupon
     * @return integer
     */
    public function compare(Coupon $coupon)
    {
        if (abs($this->Discount - $coupon->Discount) < self::MaxDelta)
            return 0;
        else
            return $this->Discount > $coupon->Discount ? 1 : -1;
    }

    /**
     * @param \user\models\User $user
     *
     * @return CouponActivation
     */
    public function createActivation($user)
    {
        $activation = new CouponActivation();
        $activation->CouponId = $this->Id;
        $activation->UserId = $user->Id;
        $activation->save();

        return $activation;
    }


    const CodeLength = 12;
    /**
     * @return string
     */
    public function generateCode()
    {
        $salt = (string) $this->EventId;
        $salt = substr($salt, max(0, strlen($salt) - 3));
        $salt = strlen($salt) == 3 ? $salt : '0'.$salt;
        $chars = 'abcdefghijkmnpqrstuvwxyz1234567890';
        $pass = '';
        while (strlen($pass) < self::CodeLength)
        {
            if ((strlen($pass)) % 4 != 0)
            {
                $invert = mt_rand(1,5);
                $pass .= ($invert == 1) ? strtoupper($chars[mt_rand(0, strlen($chars)-1)]) : $chars[mt_rand(0, strlen($chars)-1)];
            }
            else
            {
                $key = intval((strlen($pass)) / 4);
                $pass .= $salt[$key];
            }
        }
        return $pass;
    }

    const HashSecret = 'iAC2dDYNe6WUYe4QTwyDcwR2';

    /**
     * @return string
     */
    public function getHash()
    {
        return substr(md5($this->EventId.self::HashSecret.$this->Code), 0, 16);
    }
}
