<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    $this->getController()->bodyId = 'event-register';
    $this->getController()->setPageTitle('Регистрация  / ' . $this->getEvent()->Title . ' / RUNET-ID');

    \partner\models\PartnerCallback::start($this->getEvent());
    if ($this->getUser() != null)
    {
      \partner\models\PartnerCallback::registration($this->getEvent(), $this->getUser());
    }
    
    $request = \Yii::app()->getRequest();
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';

    $model = \pay\models\Product::model()->byPublic(true);
    if (!\Yii::app()->user->isGuest)
    {
      $model->byUserAccess(\Yii::app()->user->getCurrentUser()->Id, 'OR');
    }
    $products = $model->byEventId($this->event->Id)->findAll($criteria);


    $countRows = $request->getParam('count');
    if (!$request->getIsPostRequest() && count($products) == 1)
    {
      $countRows[$products[0]->Id] = 1;
    }
     
    $orderForm = new \pay\models\forms\OrderForm();
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($countRows == null && $request->getIsPostRequest())
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
        if (\pay\models\OrderItem::model()->byPayerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->exists() == false)
        {
          $orderForm->addError('Items', \Yii::t('app', 'Пожалуйста, добавьте информацию об участниках для продолжения'));
        }
        else
        {
          \partner\models\PartnerCallback::addOrderItem($this->getEvent(), $this->getUser());
          $this->getController()->redirect(
            $this->getController()->createUrl('/pay/cabinet/index', array('eventIdName' => $this->getEvent()->IdName))
          );
        }
      }
    }
    else
    {
      if (!$this->getAccount()->SandBoxUser)
      {
        if (!empty($countRows) && !$this->getUser()->Temporary)
        {
          $countRows = array_filter($countRows, function($value) {
            return $value != 0;
          });

          $isOrderItemExist = \pay\models\OrderItem::model()->byOwnerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->exists();
          if (sizeof($countRows) == 1 && !$isOrderItemExist)
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
      elseif (count($products) == 1)
      {
        $isParticipant = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->exists();
        $isOrderItemExist = \pay\models\OrderItem::model()
            ->byPayerId($this->getUser()->Id)->byOwnerId($this->getUser()->Id)
            ->byProductId($products[0]->Id)->byDeleted(false)->exists();
        if ($isParticipant && !$isOrderItemExist && $products[0]->getManager()->checkProduct($this->getUser()))
        {
          $orderForm->Items[] = array(
            'ProductId' => $products[0]->Id,
            'RunetId' => $this->getUser()->RunetId
          );
        }
      }
    }
        
    $this->getController()->render('register', [
        'event' => $this->getEvent(),
        'products' => $products,
        'orderForm' => $orderForm,
        'countRows' => $countRows,
        'registerForm' => new \user\models\forms\RegisterForm(),
        'unpaidOwnerCount' => $this->getUnpaidOwnerCount(),
        'unpaidJuridicalOrderCount' => $this->getUnpaidJuridicalOrderCount(),
        'account' => $this->getAccount()
      ]
    );
  }
  
  /**
   * Возвращает кол-во человек, на которые у текущего пользователя уже выставлены заказы
   * @return int
   */
  private function getUnpaidOwnerCount()
  {
    $count = 0;
    
    $unpaidOrderItems = \pay\models\OrderItem::model()
      ->byPayerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->byPaid(false)->findAll();
    if (!empty($unpaidOrderItems))
    {
      $ownerIdList = [];
      foreach ($unpaidOrderItems as $orderItem)
      {
        $ownerIdList[] = $orderItem->OwnerId;
      }
      $count = sizeof(array_unique($ownerIdList));
    }
    return $count;
  }
  
  private function getUnpaidJuridicalOrderCount()
  {
    return 0;
//    return \pay\models\Order::model()
//      ->byPayerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->byPaid(false)->byBankTransfer(true)->count();
  }
}
