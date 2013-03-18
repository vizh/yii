<?php

class CabinetController extends \application\components\controllers\PublicMainController
{
  public function actionRegister($eventIdName)
  {
    \Yii::app()->getClientScript()->registerPackage('runetid.pay-orderitems');
    $this->bodyId = 'event-register';

    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }
    
    $products = \pay\models\Product::model()
      ->byEventId($event->Id)->byPublic(true)->findAll();
    
    $orderForm = new \pay\models\forms\OrderForm();

    $this->render('register', array(
        'event' => $event,
        'products' => $products,
        'orderForm' => $orderForm,
        'registerForm' => new \pay\models\forms\RegisterForm(),
      )
    );
  }
}
