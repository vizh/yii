<?php
namespace pay\models;

use application\components\ActiveRecord;
use Guzzle\Http\Client;
use pay\components\CodeException;
use pay\components\coupon\managers\Base as BaseDiscountManager;
use pay\components\Exception;
use pay\components\MessageException;
use user\models\User;
use Yii;

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
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property string $ManagerName
 *
 * @property CouponActivation[] $Activations
 * @property \user\models\User $Owner
 * @property CouponLinkProduct[] $ProductLinks
 * @property Product[] $Products
 *
 * Описание вспомогательных методов
 * @method Coupon   with($condition = '')
 * @method Coupon   find($condition = '', $params = [])
 * @method Coupon   findByPk($pk, $condition = '', $params = [])
 * @method Coupon   findByAttributes($attributes, $condition = '', $params = [])
 * @method Coupon[] findAll($condition = '', $params = [])
 * @method Coupon[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Coupon byEventId(int $eventId)
 * @method Coupon byCode(string $code)
 * @method Coupon byIsTicket(bool $isTicket)
 * @method Coupon byDeleted(bool $deleted)
 */
class Coupon extends ActiveRecord
{
    protected $useSoftDelete = true;

    const MaxDelta = 0.001;

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
        return 'PayCoupon';
    }

    public function relations()
    {
        return [
            'Activations' => [self::HAS_MANY, '\pay\models\CouponActivation', 'CouponId'],
            'Owner' => [self::BELONGS_TO, '\user\models\User', 'OwnerId'],
            'ProductLinks' => [self::HAS_MANY, '\pay\models\CouponLinkProduct', 'CouponId'],
            'Products' => [self::HAS_MANY, '\pay\models\Product', ['ProductId' => 'Id'], 'through' => 'ProductLinks'],
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
     * @param int $userId
     * @param bool $useAnd
     *
     * @return Coupon
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Activations"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $criteria->with = ['Activations' => ['together' => true]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    public function getIsRightCountActivations()
    {
        if ($this->Multiple) {
            return $this->MultipleCount === null || $this->MultipleCount > count($this->Activations);
        } else {
            return count($this->Activations) === 0;
        }
    }

    public function getIsNotExpired()
    {
        $time = date('Y-m-d H:i:s');

        return $this->EndTime === null || $this->EndTime > $time;
    }

    public function getIsForProduct($productId, $strict = false)
    {
        if (empty($this->ProductLinks) && !$strict) {
            return true;
        }

        foreach ($this->ProductLinks as $link) {
            if ($link->ProductId == $productId) {
                return true;
            }
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
     * @param Product $product
     *
     * @throws \pay\components\Exception
     * @return void
     */
    public function activate($payer, $owner, $product = null)
    {
        $this->check();
        if ($this->Discount == 100) {
            $this->activate100($payer, $owner, $product);
        } else {
            $this->processOldActivations($owner);
            $this->createActivation($owner);
        }
        // toDo: Заменить на калбек из настроек мероприятия
        if ($this->EventId === 3061) {
            (new Client())->post('https://startupvillage.ru/runet-id/coupon', [
                'json' => array_merge($this->attributes, [
                    'PayerId' => $payer->RunetId,
                    'OwnerId' => $owner->RunetId,
                    'ProductId' => $product === null ? null : $product->Id
                ])
            ]);
        }
    }

    /**
     * Активирует 100% промо-код
     *
     * @param User $payer
     * @param User $owner
     * @param Product $product
     * @throws Exception
     * @throws \CDbException
     * @throws \Exception
     */
    protected function activate100($payer, $owner, $product)
    {
        $transaction = Yii::app()
            ->getDb()
            ->beginTransaction();

        $product = $this->getActivatedProduct($product);

        try {
            $this->cleanActivations($owner, $product);

            $item = OrderItem::model()
                ->byProductId($product->Id)
                ->byPayerId($payer->Id)
                ->byOwnerId($owner->Id)
                ->byDeleted(false)
                ->find();

            if ($item === null) {
                $item = new OrderItem();
                $item->ProductId = $product->Id;
                $item->PayerId = $payer->Id;
                $item->OwnerId = $owner->Id;
            }

            if ($item->activate()) {
                $link = new CouponActivationLinkOrderItem();
                $link->CouponActivationId = $this->createActivation($owner)->Id;
                $link->OrderItemId = $item->Id;
                $link->save();
            } else {
                throw new CodeException(401);
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    /**
     * @param Product $product
     *
     * @throws \pay\components\Exception
     * @return Product
     */
    protected function getActivatedProduct($product)
    {
        if (count($this->Products) === 0) {
            throw new CodeException(CodeException::NO_PRODUCT_FOR_COUPON_100);
        }
        if (count($this->Products) === 1) {
            return $this->Products[0];
        }
        foreach ($this->Products as $p) {
            if ($product !== null && $p->Id == $product->Id) {
                return $product;
            }
        }

        throw new CodeException(CodeException::WRONG_PRODUCT_FOR_COUPON_100);
    }

    /**
     * @param User $owner
     * @param Product $product
     * @throws \pay\components\MessageException
     */
    protected function cleanActivations($owner, $product)
    {
        if (count($this->Products) === 1) {
            return;
        }

        $criteria = new \CDbCriteria();
        $criteria->condition = '"OrderItem"."Paid" AND NOT "OrderItem"."Deleted"';
        $criteria->with = ['OrderItemLinks.OrderItem' => ['together' => true]];

        $activation = CouponActivation::model()
            ->byCouponId($this->Id)
            ->byUserId($owner->Id)
            ->find($criteria);

        if ($activation === null) {
            return;
        }

        $orderItem = $activation->OrderItemLinks[0]->OrderItem;
        if ($orderItem->ProductId === $product->Id) {
            throw new MessageException('Вы уже активировали 100% промо-код для этого товара ранее');
        }

        $orderItem->deactivate();
        $activation->OrderItemLinks[0]->delete();
        $activation->delete();
    }

    /**
     * @throws \pay\components\Exception
     */
    public function check()
    {
        if (!$this->getIsNotExpired()) {
            throw new CodeException(305);
        }
        if (!$this->getIsRightCountActivations()) {
            throw new CodeException(301);
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
            ->byEmptyLinkOrderItem()
            ->find();

        if ($activation !== null) {
            if ($activation->Coupon->contains($this)) {
                throw new CodeException(302);
            }
            $activation->delete();
        }
    }

    /**
     * Промо код А содержит промо код Б, если множество товаров А содержит множество товаров Б,
     * и скидка промо кода А, больше либо равна скидки промо кода Б.
     *
     * @param Coupon $coupon
     * @return boolean
     */
    public function contains(Coupon $coupon)
    {
        if (false === empty($this->Products)) {
            if (empty($coupon->Products)) {
                return true;
            }

            foreach ($coupon->Products as $product1) {
                $hasPair = false;
                foreach ($this->Products as $product2) {
                    if ($product1->Id == $product2->Id) {
                        $hasPair = true;
                    }
                }
                if ($hasPair === false) {
                    return false;
                }
            }
        }

        return $this->compare($coupon) >= 0;
    }

    /**
     * Возвращает:
     * 0 - если размер скидки одинаковый,
     * 1 - если размер скидки объекта больше чем размер скидки аргумента,
     * -1 - если размер скидки аргумента больше чем размер скидки объекта.
     *
     * @param Coupon $coupon
     * @return integer
     */
    public function compare(Coupon $coupon)
    {
        if ($this->Discount == $coupon->Discount) {
            return 0;
        } else {
            return $this->Discount > $coupon->Discount ? 1 : -1;
        }
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
        $salt = (string)$this->EventId;
        $salt = substr($salt, max(0, strlen($salt) - 3));
        $salt = strlen($salt) == 3 ? $salt : '0'.$salt;
        $chars = 'abcdefghijkmnpqrstuvwxyz1234567890';
        $pass = '';
        while (strlen($pass) < self::CodeLength) {
            if ((strlen($pass)) % 4 != 0) {
                $invert = mt_rand(1, 5);
                $pass .= ($invert == 1) ? strtoupper($chars[mt_rand(0, strlen($chars) - 1)]) : $chars[mt_rand(0, strlen($chars) - 1)];
            } else {
                $key = (int)((strlen($pass)) / 4);
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

    private $manager;

    /**
     * @return BaseDiscountManager
     */
    public function getManager()
    {
        if ($this->manager === null) {
            $class = '\pay\components\coupon\managers\\'.$this->ManagerName;
            $this->manager = new $class($this);
        }

        return $this->manager;
    }
}
