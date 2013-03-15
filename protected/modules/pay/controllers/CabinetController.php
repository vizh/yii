<?php
class CabinetController extends \application\components\controllers\PublicMainController
{
  public function actionRegister($eventIdName)
  {
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }
    
    $products = \pay\models\Product::model()
      ->byEventId($event->Id)->byPublic(true)->findAll();
    
    $order = new \pay\models\forms\OrderForm();
    $this->bodyId = 'event-register';
    $this->render('register', array('products' => $products, 'order' => $order));
  }
}
