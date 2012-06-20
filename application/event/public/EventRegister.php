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
      $product = Product::GetById($event->FastProduct);
      $this->view->Product = $product;
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
        elseif (!empty($product))
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
    else
    {
      $this->view->SetTemplate('not-auth');
    }


    echo $this->view;
  }
}
