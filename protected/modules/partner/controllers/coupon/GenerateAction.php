<?php
namespace partner\controllers\coupon;

use pay\models\Product;

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
    $form->setScenario($form->type);
    $result = [];
    if ($request->getIsPostRequest() && $form->validate())
    {
      $result = $form->generate();
      $form = new \partner\models\forms\coupon\Generate();
      $form->event = $this->getEvent();
    }

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ManagerName" != :ManagerName');
    $criteria->params['ManagerName'] = 'RoomProductManager';
    $products = Product::model()->byEventId($form->event->Id)->byDeleted(false)->findAll($criteria);

    $this->getController()->render('generate', array(
      'products' => $products,
      'form' => $form,
      'result' => $result,
      'event' => $this->getEvent()
    ));
  }
}
