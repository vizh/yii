<?php
AutoLoader::Import('library.rocid.pay.*');

class EventRegister extends GeneralCommand
{


  /**
   * Основные действия комманды
   * @param string $idName
   * @return void
   */
  protected function doExecute($idName = '')
  {
    $event = Event::GetEventByIdName($idName);
    $product = null;
    if (empty($event) || ($event->FastRole == null && $event->FastProduct == null))
    {
      $this->Send404AndExit();
    }

    $this->view->Event = $event;
    if (!empty($event->FastProduct))
    {
      $list = explode(',', $event->FastProduct);
      $criteria = new CDbCriteria();
      $criteria->addInCondition('t.ProductId', $list);
      $products = Product::model()->findAll($criteria);
      $this->view->Products = $products;
    }

    if ($this->LoginUser !== null)
    {
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        if (!empty($event->FastRole))
        {
          $role = EventRoles::GetById($event->FastRole);
          if (!empty($role))
          {
            $event->RegisterUser($this->LoginUser, $role);
          }
          $this->view->SetTemplate('success');
        }
        elseif (!empty($products))
        {
          $productId = Registry::GetRequestVar('productId', null);
          $product = null;
          foreach ($products as $prod)
          {
            if ($prod->ProductId == $productId)
            {
              $product = $prod;
              break;
            }
          }
          if (!empty($product))
          {
            $orderItem = OrderItem::GetByAll($product->ProductId, $this->LoginUser->UserId, $this->LoginUser->UserId);
            if (empty($orderItem))
            {
              $product->ProductManager()->CreateOrderItem($this->LoginUser, $this->LoginUser);
            }
            Lib::Redirect('http://pay.rocid.ru/' . $event->EventId . '/');
          }
        }
      }
    }
    else
    {
      $this->view->SetTemplate('not-auth');
    }


    echo $this->view;
  }
}
