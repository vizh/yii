<?php
namespace partner\controllers\coupon;

class GiveAction extends \partner\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $couponsId = $request->getParam('Coupons', array());
    $coupons = array();
    $success = false;
    $error = false;
    if ( !empty ($couponsId))
    {
      $criteria = new \CDbCriteria();
      $criteria->condition = 't.EventId = :EventId';
      $criteria->params = array(
        ':EventId' => \Yii::app()->partner->getAccount()->EventId
      );
      $criteria->addInCondition('t.Code', $couponsId);

      /** @var $coupons \pay\models\Coupon[] */
      $coupons = \pay\models\Coupon::model()->findAll($criteria);

      if ( isset($_REQUEST['Give']) && $request->getIsPostRequest())
      {
        foreach ($coupons as $coupon)
        {
          $coupon->Recipient = date('d.m.Y') .': '. $_REQUEST['Give']['Recipient'] .'; '. $coupon->Recipient;
          $coupon->save();
        }
        $success = 'Промо-коды выданы!';
      }
    }
    else
    {
      $error = 'Не выбраны промо-коды для выдачи.';
    }

    $this->getController()->render('give', array(
      'coupons' => $coupons,
      'success' => $success,
      'error' => $error
    ));
  }
}
