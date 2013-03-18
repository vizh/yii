<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \CAction
{
  public function run($eventIdName)
  {
    \Yii::app()->getClientScript()->registerPackage('runetid.pay-orderitems');
    $this->getController()->bodyId = 'event-register';

    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }

    $products = \pay\models\Product::model()
        ->byEventId($event->Id)->byPublic(true)->findAll();

    $orderForm = new \pay\models\forms\OrderForm();

    $this->getController()->render('register', array(
        'event' => $event,
        'products' => $products,
        'orderForm' => $orderForm,
        'registerForm' => new \pay\models\forms\RegisterForm(),
      )
    );
  }
}
