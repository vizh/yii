<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionCouponActivate($code, $eventIdName, $ownerRunetId, $productId)
  {
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($event == null || $owner == null)
    {
      throw new CHttpException(404);
    }
    
    $result = new \stdClass();
    $coupon = \pay\models\Coupon::model()->byCode($code)->byEventId($event->Id)->find();
    if ($code == null
      || ($coupon->ProductId !== null && $coupon->ProductId != $productId))
    {
      $result->error = \Yii::t('app', 'Указан неверный код купона');
      $result->success = false;
    }
    else
    {
      try 
      {
        $coupon->activate(\Yii::app()->user->CurrentUser(), $owner);
      }
      catch(\pay\components\Exception $e)
      {
        $result->error = $e->getMessage();
        $result->success = false;
      }
      $result->success = true;
    }
    echo json_encode($result);
  }
}
