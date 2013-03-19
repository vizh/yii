<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \CAction
{
  public function run($eventIdName)
  {
    $this->getController()->bodyId = 'event-register';

    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }
    
    $products = \pay\models\Product::model()
        ->byEventId($event->Id)->byPublic(true)->findAll();

    $request = \Yii::app()->getRequest();
    $orderForm = new \pay\models\forms\OrderForm();
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($request->getIsPostRequest())
    {
      foreach ($orderForm->Items as $iter)
      {
        
      }
    }
    
    $countRows = $request->getParam('count');
    foreach ($products as $product)
    {
      if (!isset($countRows[$product->Id]) || intval($countRows[$product->Id]) <= 0)
      {
        $countRows[$product->Id] = 1;
      }
    }
      
    
    
    
    $this->getController()->render('register', array(
        'event' => $event,
        'products' => $products,
        'orderForm' => $orderForm,
        'countRows' => $countRows,
        'registerForm' => new \user\models\forms\RegisterForm(),
      )
    );
  }
}
