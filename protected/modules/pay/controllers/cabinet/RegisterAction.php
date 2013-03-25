<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    $this->getController()->bodyId = 'event-register';

    $this->getController()->setPageTitle('Регистрация  / ' . $this->getEvent()->Title . ' / RUNET-ID');
    
    $request = \Yii::app()->getRequest();
    
    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->findAll();
    
    $countRows = $request->getParam('count');
    foreach ($products as $product)
    {
      if (!isset($countRows[$product->Id]) || intval($countRows[$product->Id]) <= 0)
      {
        $countRows[$product->Id] = 1;
      }
    }
    

    $orderForm = new \pay\models\forms\OrderForm();
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($request->getParam('count') == null && $request->getIsPostRequest())
    {
      foreach ($orderForm->Items as $k => $item)
      {
        $product = \pay\models\Product::model()->findByPk($item['ProductId']);
        if ($product == null)
        {
          $orderForm->addError('Items', \Yii::t('app', 'Продукт не найден.'));
        }
        
        $owner = \user\models\User::model()->byRunetId($item['RunetId'])->find();
        if ($owner == null)
        {
          $orderForm->addError('Items', \Yii::t('app', 'Пользователь с RUNET-ID: {RunetId} не найден.', array('{RunetId}' => $item['RunetId'])));
        }
        if (!empty($item['PromoCode']))
        {
          $coupon = \pay\models\Coupon::model()->byCode($item['PromoCode'])->find();
          if ($coupon !== null 
            && ($coupon->ProductId == null || $coupon->ProductId == $product->Id))
          {
            try
            {
              $coupon->activate(\Yii::app()->user->getCurrentUser(), $owner);
            }
            catch (\pay\components\Exception $e) {}
          }
        }
        
        try
        {
          $product->getManager()->createOrderItem(\Yii::app()->user->getCurrentUser(), $owner);
        }
        catch(\pay\components\Exception $e)
        {
          if ($e->getCode() !== 701)
          {
            $orderForm->addError('Items', $e->getMessage());
          }
        }
      }
      if (!$orderForm->hasErrors())
      {
        $this->getController()->redirect(
          $this->getController()->createUrl('/pay/cabinet/index', array('eventIdName' => $this->getEvent()->IdName))
        );
      }
    }
        
    $this->getController()->render('register', array(
        'event' => $this->getEvent(),
        'products' => $products,
        'orderForm' => $orderForm,
        'countRows' => $countRows,
        'registerForm' => new \user\models\forms\RegisterForm(),
      )
    );
  }
}
