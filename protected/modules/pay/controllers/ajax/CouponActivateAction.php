<?php
namespace pay\controllers\ajax;

class CouponActivateAction extends \pay\components\Action
{
  public function run($code, $eventIdName, $ownerRunetId, $productId)
  {
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($event == null || $owner == null)
    {
      throw new \CHttpException(404);
    }
    
    $result = new \stdClass();
    $result->success = true;
    /** @var $coupon \pay\models\Coupon */
    $coupon = \pay\models\Coupon::model()->byCode($code)->byEventId($event->Id)->find();
    if ($coupon == null
      || ($coupon->ProductId !== null && $coupon->ProductId != $productId))
    {
      $result->error = \Yii::t('app', 'Указан неверный код купона');
      $result->success = false;
    }
    else
    {
      try 
      {
        $coupon->activate(\Yii::app()->user->getCurrentUser(), $owner);
      }
      catch(\pay\components\Exception $e)
      {
        $result->error = $e->getMessage();
        $result->success = false;
      }
      
      if ($result->success)
      {
        $result->message = \Yii::t('app', 'Купон на скидку {discount}% успешно активирован!', array('{discount}' => $coupon->Discount*100));
      }
    }
    echo json_encode($result);
  }
}
