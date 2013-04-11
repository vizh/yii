<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $ProductId
 * @property string $Code
 * @property float $Discount
 * @property bool $Multiple
 * @property int $MultipleCount
 * @property string $Recipient
 * @property string $CreationTime
 * @property string $EndTime
 *
 * @property CouponActivation[] $Activations
 * @property Product $Product
 */
class Coupon extends \CActiveRecord
{

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
    return array(
      'Activations' => array(self::HAS_MANY, '\pay\models\CouponActivation', 'CouponId'),
      'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId')
    );
  }

  public function __get($name)
  {
    if ($name === 'Discount')
    {
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


  /**
   * @static
   *
   * @param \user\models\User $payer
   * @param \user\models\User $owner
   *
   * @throws \pay\components\Exception
   * @return void
   */
  public function activate($payer, $owner)
  {
    if (!$this->getIsNotExpired())
    {
      throw new \pay\components\Exception(\Yii::t('app','Срок действия вашего промо кода истек'), 305);
    }
    if (!$this->getIsRightCountActivations())
    {
      throw new \pay\components\Exception(\Yii::t('app','Превышено максимальное количество активаций промо кода'), 301);
    }

    if (abs($this->Discount - 1.00) < 0.00001)
    {
      if (empty($this->Product))
      {
        throw new \pay\components\Exception(\Yii::t('app','Для промо кода со скидкой 100% не указан товар, на который распространяется скидка'), 303);
      }

      $item = OrderItem::model()
          ->byProductId($this->ProductId)
          ->byPayerId($payer->Id)->byOwnerId($owner->Id)
          ->byDeleted(false)->find();
      if ($item === null)
      {
        $item = new OrderItem();
        $item->ProductId = $this->ProductId;
        $item->PayerId = $payer->Id;
        $item->OwnerId = $owner->Id;
      }
      if ($item->activate())
      {
        $activation = $this->createActivation($owner);

        $link = new CouponActivationLinkOrderItem();
        $link->CouponActivationId= $activation->Id;
        $link->OrderItemId = $item->Id;
        $link->save();
      }
      else
      {
        throw new \pay\components\Exception(\Yii::t('app','Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар'), 304);
      }
    }
    else
    {
      $this->processOldActivations($owner);
      $this->createActivation($owner);
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

    if ($activation !== null)
    {
      if ($activation->Coupon->Discount >= $this->Discount)
      {
        throw new \pay\components\Exception(\Yii::t('app','У пользователя уже активирован промо код с бОльшей скидкой'), 302);
      }
      else
      {
        $activation->delete();
      }
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
}
