<?php
namespace pay\models;

/**
 * @property int $CouponId
 * @property int $EventId
 * @property int $ProductId
 * @property string $Code
 * @property float $Discount
 * @property int $Multiple
 * @property string $Recipient
 * @property string $CreationTime
 * @property string $EndTime
 *
 * @property CouponActivated[] $CouponActivatedList
 * @property Product $Product
 */
class Coupon extends \CActiveRecord
{
  public static $TableName = 'Mod_PayCoupon';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'CouponId';
  }

  public function relations()
  {
    return array(
      'CouponActivatedList' => array(self::HAS_MANY, '\pay\models\CouponActivated', 'CouponId'),
      'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId')
    );
  }

  /**
   * @static
   * @param string $code
   * @return Coupon
   */
  public static function GetByCode($code)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Code = :Code';
    $criteria->params = array(':Code' => $code);

    return Coupon::model()->with('CouponActivatedList')->find($criteria);
  }

  /**
   * @static
   * @param int $userId
   * @param int $eventId
   * @return Coupon
   */
  public static function GetByUser($userId, $eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('CouponActivatedList' => array('together' => true));
    $criteria->condition = 't.EventId = :EventId AND CouponActivatedList.UserId = :UserId';
    $criteria->params = array(':EventId' => $eventId, ':UserId' => $userId);
    $criteria->order = 'CouponActivatedList.CreationTime DESC';

    return Coupon::model()->find($criteria);
  }

  /**
   * @static
   * @param \user\models\User $payer
   * @param \user\models\User $owner
   * @throws PayException
   * @return void
   */
  public function Activate($payer, $owner)
  {
    if (!empty($this->CouponActivatedList) && $this->Multiple == 0 || (sizeof($this->CouponActivatedList) >= $this->Multiple && $this->Multiple != 0))
    {
      throw new PayException('Превышено максимальное количество активаций промо кода.', 301);
    }

    $time = date('Y-m-d H:i:s');

    //todo: Создать адекватный вывод ошибки
    if ($this->EndTime != null && $this->EndTime < $time)
    {
      throw new PayException('Срок действия вашего промо кода истек.', 305);
    }

    $oldCoupon = Coupon::GetByUser($owner->UserId, $this->EventId);
    if (!empty($oldCoupon) && empty($oldCoupon->CouponActivatedList[0]->OrderItems))
    {
      if ($oldCoupon->Discount >= $this->Discount)
      {
        throw new PayException('У пользователя уже активирован промо код с бОльшей скидкой.', 302);
      }
      else
      {
        $oldCoupon->CouponActivatedList[0]->delete();
      }
    }



    //Активируем купон
    $couponActivated = new CouponActivated();
    $couponActivated->CouponId = $this->CouponId;
    $couponActivated->UserId = $owner->UserId;
    $couponActivated->CreationTime = $time;
    $couponActivated->save();

    //OrderItem::AddCouponActivated($couponActivated->CouponActivatedId, $owner->UserId, $coupon->Product->ProductId);

    if (intval($this->Discount) == 1)
    {
      // 2. Проверить, может ли пользователь купить товар, на который купон активируется
      //    if (!$coupon->Product->ProductManager()->CheckProduct($owner))
      //    {
      //      $this->SendJson(true, 207, '');
      //    }
      if (empty($this->Product))
      {
        $couponActivated->delete();
        throw new PayException('Для промо кода со скидкой 100% не указан товар, на который распространяется скидка.', 303);
      }

      $flag = $this->Product->ProductManager()->BuyProduct($owner);
      if (!$flag)
      {
        $couponActivated->delete();
        throw new PayException('Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар.', 304);
      }

      $item = OrderItem::GetByAll($this->ProductId, $payer->UserId, $owner->UserId);
      if (!empty($item))
      {
        $item->PaidTime = $time;
        $item->Paid = 1;
        $item->save();
      }
      else
      {
        $item = new OrderItem();
        $item->ProductId = $this->ProductId;
        $item->PayerId = $payer->UserId;
        $item->OwnerId = $owner->UserId;
        $item->PaidTime = $time;
        $item->Paid = 1;
        $item->save();
      }
      $link = new CouponActivatedOrderItemLink();
      $link->CouponActivatedId = $couponActivated->CouponActivatedId;
      $link->OrderItemId = $item->OrderItemId;
      $link->save();
    }
  }

  const CodeLength = 12;
  /**
   * @return string
   */
  public function GenerateCode()
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
