<?php
namespace partner\controllers\coupon;

class GiveAction extends \partner\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."Code"', $request->getParam('Coupons'));
    $coupons = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
    if (empty($coupons))
      throw new \CHttpException(404);

    $form = new \partner\models\forms\coupon\Give();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      foreach ($coupons as $coupon)
      {
        $coupon->Recipient = \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', time()).': '.$form->Recipient.'; '.$coupon->Recipient;
        $coupon->save();
      }
      \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Промо-коды выданы!'));
      $this->getController()->refresh();
    }
    
    $this->getController()->render('give', array(
      'coupons' => $coupons,
      'form' => $form
    ));
  }
}
