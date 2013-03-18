<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionCouponactivate($code, $eventIdName, $productId, $ownerId)
  {
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }
    
    $coupon = \pay\models\Coupon::model()->byCode($code)->byEventId($event->Id)->find();
    $result = new \stdClass();
    $result->success = false;
    
    if ($coupon == null)
    {
      $result->error = \Yii::t('app', 'Введен не верный код купона');
    }
    else if (!$coupon->Multiple && !empty($coupon->Activations))
    {
      if ($coupon->Activations[0]->UserId == $user->Id)
      {
        $result->error = \Yii::t('app', 'Вы уже активировали этот код купона');
      }
      else
      {
        $result->error = \Yii::t('app', 'Введен не верный код купона');
      }
    }
    else if ($coupon->EndTime !== null && $coupon->EndTime <= date('Y-m-d H:i:s'))
    {
      $result->error = \Yii::t('app', 'Срок действия купона истек');
    }
    else if ($coupon->ProductId !== null)
  }
}
