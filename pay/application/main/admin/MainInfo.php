<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class MainInfo extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $orderId = Registry::GetRequestVar('orderId', null);
      $rocId = Registry::GetRequestVar('rocId', null);
      $eventId = 245;

      $items = array();
      if (!empty($orderId))
      {
        $order = Order::GetById($orderId);
        if (!empty($order))
        {
          $items = $order->Items;
          $this->view->OrderId = $order->OrderId;
        }
        else
        {
          $this->view->Error = 'Не найден заказ с номером ' . $orderId;
        }
      }
      elseif (!empty($rocId))
      {
        $user = User::GetByRocid($rocId);
        if (!empty($user))
        {
          $criteria = new CDbCriteria();
          $criteria->condition = 't.Deleted = :Deleted AND Product.EventId = :EventId AND (t.PayerId = :UserId OR t.OwnerId = :UserId)';
          $criteria->params = array(
            ':Deleted' => 0,
            ':EventId' => $eventId,
            ':UserId' => $user->UserId
          );

          $items = OrderItem::model()->with(array('Product', 'Payer', 'Owner', 'Params'))->findAll($criteria);
          $this->view->User = $user;
        }
        else
        {
          $this->view->Error = 'Не найден пользователь с rocID ' . $rocId;
        }
      }

      $this->view->SetTemplate('result');
      $this->view->Items = $items;
    }

    echo $this->view;
  }
}
