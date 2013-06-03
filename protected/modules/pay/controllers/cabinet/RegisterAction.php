<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    $this->getController()->bodyId = 'event-register';

    $this->getController()->setPageTitle('Регистрация  / ' . $this->getEvent()->Title . ' / RUNET-ID');
    
    $request = \Yii::app()->getRequest();
    
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" ASC';
    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->findAll($criteria);
    
    $countRows = $request->getParam('count');
    
    $orderForm = new \pay\models\forms\OrderForm();
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($request->getParam('count') == null && $request->getIsPostRequest())
    {
      foreach ($orderForm->Items as $k => $item)
      {
        $product = \pay\models\Product::model()->findByPk($item['ProductId']);
        if ($product === null)
        {
          throw new \CHttpException(404);
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
              $coupon->activate($this->getUser(), $owner);
            }
            catch (\pay\components\Exception $e) {}
          }
        }
        
        try
        {
          $product->getManager()->createOrderItem($this->getUser(), $owner);
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
        if (\pay\models\OrderItem::model()->byPayerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)
          ->exists() == false)
        {
          $orderForm->addError('Items', \Yii::t('app', 'Пожалуйста, добавьте информацию об участниках для продолжения'));
        }
        else
        {
          $this->getController()->redirect(
            $this->getController()->createUrl('/pay/cabinet/index', array('eventIdName' => $this->getEvent()->IdName))
          );
        }
      }
    }
    else
    {
      if (!empty($countRows) && !$this->getUser()->Temporary)
      {
        $countRows = array_filter($countRows, function($value) {
          return $value != 0;
        });

        if (sizeof($countRows) == 1
          && \pay\models\OrderItem::model()->byOwnerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->exists() == false)
        {
          $orderForm->Items[] = array(
            'ProductId' => key($countRows),
            'RunetId' => $this->getUser()->RunetId
          );
        }

        foreach ($products as $product)
        {
          if (!isset($countRows[$product->Id]))
          {
            $countRows[$product->Id] = 1;
          }
        }
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
