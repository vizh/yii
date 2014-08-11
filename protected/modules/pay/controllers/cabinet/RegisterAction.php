<?php
namespace pay\controllers\cabinet;

class RegisterAction extends \pay\components\Action
{
  private $form;

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
    $products = $this->getProducts();


    $countRows = $request->getParam('count');
    if (!$request->getIsPostRequest() && count($products) == 1)
    {
      $countRows[$products->all[0]->Id] = 0;
    }
     
    $this->form = new \pay\models\forms\OrderForm();
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($countRows == null && $request->getIsPostRequest())
    {
      $this->form->setScenario($this->form->Scenario);
      switch ($this->form->getScenario())
      {
        case \pay\models\forms\OrderForm::ScenarioRegisterUser:
          $this->processFormRegisterUser();
          break;

        case \pay\models\forms\OrderForm::ScenarioRegisterTicket:
          $this->processFormRegisterTicket();
          break;

        default:
          $this->afterProcessForm();
          break;
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
            $productId = key($countRows);
            $product = \pay\models\Product::model()->findByPk($productId);
            $this->form->Items[] = array(
              'ProductId' => $productId,
              'RunetId' => $this->getUser()->RunetId,
              'Discount' => $this->getDiscount($this->getUser(), $product)
            );
          }

          foreach ($products->all as $product)
          {
            if (!isset($countRows[$product->Id]))
            {
              $countRows[$product->Id] = 0;
            }
          }
        }
      }
      elseif (count($products->participations) == 1)
      {
        $isParticipant = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->exists();
        $isOrderItemExist = \pay\models\OrderItem::model()
            ->byPayerId($this->getUser()->Id)->byOwnerId($this->getUser()->Id)
            ->byProductId($products->participations[0]->Id)->byDeleted(false)->exists();
        if ($isParticipant && !$isOrderItemExist && $products->participations[0]->getManager()->checkProduct($this->getUser()))
        {
          $this->form->Items[] = [
            'ProductId' => $products->participations[0]->Id,
            'RunetId' => $this->getUser()->RunetId,
            'Discount' => $this->getDiscount($this->getUser(), $products->participations[0])
          ];
        }
      }
    }

    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
    $this->getController()->render('register', [
        'event' => $this->getEvent(),
        'products' => $products,
        'orderForm' => $this->form,
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

  private $activations = [];

  /**
   * @param \user\models\User $user
   * @param \pay\models\Product $product
   * @return float|int
   */
  private function getDiscount(\user\models\User $user, \pay\models\Product $product)
  {
    if (!isset($this->activations[$user->Id]))
    {
      /** @var $activation \pay\models\CouponActivation */
      $activation = \pay\models\CouponActivation::model()
          ->byUserId($user->Id)
          ->byEventId($this->getEvent()->Id)
          ->byEmptyLinkOrderItem()->find();

      $this->activations[$user->Id] = $activation;
    }
    $activation = $this->activations[$user->Id];
    if ($activation == null)
      return 0;
    return $activation->getDiscount($product);
  }

  private $products = null;

  /**
   * @return \stdClass
   */
  private function getProducts()
  {
    if ($this->products == null)
    {
      $criteria = new \CDbCriteria();
      $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';
      $model = \pay\models\Product::model()->byPublic(true);
      if (!\Yii::app()->user->isGuest)
      {
        $model->byUserAccess(\Yii::app()->user->getCurrentUser()->Id, 'OR');
      }

      $products = $model->byEventId($this->event->Id)->findAll($criteria);
      $this->products = new \stdClass();
      $this->products->all = [];
      $this->products->participations = [];
      $this->products->tickets = [];
      foreach ($products as $product)
      {
        if ($product->ManagerName == 'Ticket')
        {
          $this->products->tickets[] = $product;
        }
        else
        {
          if (substr($product->ManagerName, 0, 5) == 'Event')
            $this->products->participations[] = $product;
          $this->products->all[] = $product;
        }
      }
    }

    return $this->products;
  }

  /**
   * @param int $productId
   * @return \pay\models\Product
   */
  private function getProduct($productId)
  {
    $products = $this->getProducts();
    foreach (['all', 'tickets'] as $key)
    {
      foreach ($products->$key as $product)
      {
        if ($product->Id == $productId)
          return $product;
      }
    }
    return null;
  }


  private function processFormRegisterUser()
  {
    foreach ($this->form->Items as $k => $item)
    {
      $product = $this->getProduct($item['ProductId']);
      if ($product === null)
      {
        throw new \CHttpException(404);
      }

      $owner = \user\models\User::model()->byRunetId($item['RunetId'])->find();
      if ($owner == null)
      {
        $this->form->addError('Items', \Yii::t('app', 'Пользователь с RUNET-ID: {RunetId} не найден.', array('{RunetId}' => $item['RunetId'])));
      }
      else
      {
        $this->form->Items[$k]['Owner'] = $owner;
      }

      try
      {
        $product->getManager()->createOrderItem($this->getUser(), $owner);
      }
      catch(\pay\components\Exception $e)
      {
        if ($e->getCode() !== 701)
        {
          $this->form->addError('Items', $e->getMessage());
        }
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
    }

    $this->afterProcessForm();
    foreach ($this->form->Items as $key => $item)
    {
      if (!empty($item['Owner']))
      {
        $this->form->Items[$key]['Discount'] = $this->getDiscount($item['Owner'], $this->getProduct($item['ProductId']));
      }
    }
  }

  private function processFormRegisterTicket()
  {
    foreach ($this->form->Items as $item)
    {
      $product = $this->getProduct($item['ProductId']);
      if ($product == null)
      {
        throw new \CHttpException(404);
      }
      $count = intval($item['Count']);
      if ($count == 0)
        continue;

      try
      {
        $product->getManager()->createOrderItem($this->getUser(), $this->getUser(), null, ['Count' => $count]);
      }
      catch(\pay\components\Exception $e)
      {
        $this->form->addError('Items', $e->getMessage());
      }
    }
    $this->afterProcessForm();
  }

  private function afterProcessForm()
  {
    if (!$this->form->hasErrors())
    {
      if (\pay\models\OrderItem::model()->byPayerId($this->getUser()->Id)->byEventId($this->getEvent()->Id)->byDeleted(false)->exists() == false)
      {
        $this->form->addError('Items', \Yii::t('app', 'Пожалуйста, добавьте информацию об участниках для продолжения'));
      }
      else
      {
        \partner\models\PartnerCallback::addOrderItem($this->getEvent(), $this->getUser());
        $this->getController()->redirect(
          $this->getController()->createUrl('/pay/cabinet/index', ['eventIdName' => $this->getEvent()->IdName])
        );
      }
    }
  }
}
