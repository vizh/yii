<?php
namespace partner\controllers\coupon;

class GenerateAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Генерация промо-кодов');
    $this->getController()->initActiveBottomMenu('generate');

    $request = \Yii::app()->getRequest();

    $form = new \partner\models\forms\coupon\Generate();
    $form->event = \Yii::app()->partner->getEvent();
    $form->attributes = $request->getParam(get_class($form));

    $result = false;
    if ($request->getIsPostRequest() && $form->validate())
    {
      $result = $this->generate($form);
      $form = new \partner\models\forms\coupon\Generate();
      $form->event = \Yii::app()->partner->getEvent();
    }

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ManagerName" != :ManagerName');
    $criteria->params['ManagerName'] = 'RoomProductManager';
    $products = \pay\models\Product::model()->byEventId($form->event->Id)->findAll($criteria);

    $this->getController()->render('generate', array(
      'products' => $products,
      'form' => $form,
      'result' => $result
    ));
  }

  /**
   * @param \partner\models\forms\coupon\Generate $form
   * @return string
   */
  private function generate($form)
  {
    $result = '';
    for ($i=0; $i<$form->count; $i++)
    {
      $coupon = new \pay\models\Coupon();
      $coupon->EventId = $form->event->Id;
      $coupon->Discount = (float) $form->discount / 100;
      $coupon->ProductId = $form->product !== null ? $form->product->Id : null;
      $coupon->Code = $coupon->generateCode();
      $coupon->save();

      $result .= $coupon->Code . '<br>';
    }

    return $result;
  }
}
