<?php
namespace pay\controllers\cabinet;

class IndexAction extends \pay\components\Action
{


  public function run($eventIdName)
  {
    $this->getController()->setPageTitle('Оплата  / ' .$this->getEvent()->Title . ' / RUNET-ID');

    $account = $this->getAccount();

    $orderItems = \pay\models\OrderItem::getFreeItems(\Yii::app()->user->getCurrentUser()->Id, $this->getController()->getEvent()->Id);
    $unpaidItems = array();
    $paidItems = array();
    $recentPaidItems = array();

    foreach ($orderItems as $orderItem)
    {
      if (!$orderItem->Paid)
      {
        if ($orderItem->Product->getManager()->checkProduct($orderItem->Owner))
        {
          $unpaidItems[$orderItem->Product->Id][] = $orderItem;
        }
        else
        {
          $orderItem->delete();
        }
      }
      else
      {
        if ($orderItem->PaidTime > date('Y-m-d H:i:s', time() - 10*60*60))
        {
          $recentPaidItems[] = $orderItem;
        }
        else
        {
          $paidItems[] = $orderItem;
        }
      }
    }

    $orders = \pay\models\Order::model()
        ->byPayerId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->getEvent()->Id)
        ->byJuridical(true)->byDeleted(false)->findAll();

    $this->getController()->render('index', array(
      'unpaidItems' => $unpaidItems,
      'paidItems' => $paidItems,
      'recentPaidItems' => $recentPaidItems,
      'orders' => $orders,
      'account' => $account
    ));
  }

  private function getAccount()
  {
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($account === null)
    {
      throw new \pay\components\Exception('Для работы платежного кабинета необходимо создать платежный аккаунт мероприятия.');
    }
    return $account;
  }
}
