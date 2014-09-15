<?php
namespace pay\controllers\ajax;

class CouponActivateAction extends \pay\components\Action
{
  public function run($code, $eventIdName, $ownerRunetId, $productId)
  {
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($owner == null)
    {
      throw new \CHttpException(404);
    }
    
    $result = new \stdClass();
    $result->success = true;
    /** @var $coupon \pay\models\Coupon */
    $coupon = \pay\models\Coupon::model()->byCode($code)->byEventId($this->getEvent()->Id)->find();
    if ($coupon == null
      || ($coupon->ProductId !== null && $coupon->ProductId != $productId && $coupon->Discount != 1))
    {
      $result->error = \Yii::t('app', 'Указан неверный код купона');
      $result->success = false;
    }
    else
    {
      try 
      {
        $coupon->activate($this->getUser(), $owner);
      }
      catch(\pay\components\Exception $e)
      {
        $result->error = $e->getMessage();
        $result->success = false;
      }
      
      if ($result->success)
      {
        if ($coupon->Discount == 1)
        {
          $criteria = new \CDbCriteria();
          $criteria->with = ['Role' => ['together' => true]];
          $criteria->order = '"Role"."Priority" DESC';
          $participant = \event\models\Participant::model()
              ->byEventId($this->getEvent()->Id)->byUserId($owner->Id)->find($criteria);
          $result->message = \Yii::t('app', 'Регистрация на мероприятие прошла успешно! Промо-код на скидку 100% активирован. Статус: "{RoleTitle}".', ['{RoleTitle}' => $participant->Role->Title]);
        }
        else
        {
          $result->message = \Yii::t('app', 'Купон на скидку {discount}% успешно активирован!', array('{discount}' => $coupon->Discount*100));
        }

        $result->coupon = new \stdClass();
        $result->coupon->Code = $code;
        $result->coupon->Discount = $coupon->Discount;
      }
    }
    echo json_encode($result);
  }
}
