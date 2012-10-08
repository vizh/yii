<?php
namespace partner\controllers\order;

class CreateAction extends \partner\components\Action
{

  /** @var \user\models\User */
  public $payer;

  public $error;

  public function run()
  {
    $this->getController()->setPageTitle('Выставление счета');
    $this->getController()->initActiveBottomMenu('createbill');

    $payerRocId = \Yii::app()->getRequest()->getParam('payerRocId');
    if (!empty($payerRocId))
    {
      $this->payer = \user\models\User::GetByRocid($payerRocId);
      $this->stepCreateOrder();
    }
    else
    {
      $this->stepIndex();
    }
  }

  private function stepIndex ()
  {
    $request = \Yii::app()->request;
    $createOrder = $request->getParam('CreateOrder');

    if ($request->getIsPostRequest() && !empty($createOrder))
    {

      $payerRocId = (int) $createOrder['Payer']['RocId'];
      if ($payerRocId != 0)
      {
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/order/create', array('payerRocId' => $payerRocId)));
      }
      else
      {
        $this->error = 'Не указан плательщик';
      }
    }
    $this->getController()->render('create-index');
  }

  private function stepCreateOrder ()
  {
    if ( !isset ($this->payer))
    {
      $this->stepIndex();
      $this->error = 'Плательщик не найден';
      return;
    }

    $allOrderItems = \pay\models\OrderItem::GetByEventId($this->payer->UserId, \Yii::app()->partner->getAccount()->EventId);
    $orderItems = array();

    if ( !empty ($allOrderItems))
    {
      foreach ($allOrderItems as $orderItem)
      {
        if ( $orderItem->Product->ProductManager()->CheckProduct( $orderItem->Owner))
        {
          $orderItems[] = $orderItem;
        }
        else
        {
          $orderItem->Deleted = 1;
          $orderItem->save();
        }
      }
    }

    if (empty ($orderItems))
    {
      $this->stepIndex();
      $this->error = 'На пользователя с rocID: '. $this->payer->RocId .' нет ни одного заказа';
      return;
    }

    $request = \Yii::app()->request;
    $createOrder = $request->getParam('CreateOrder');
    if ( $request->getIsPostRequest() && !empty($createOrder))
    {
      if ( $this->createOrderValidateForm($createOrder))
      {
        \pay\models\Order::CreateOrder($this->payer, \Yii::app()->partner->getAccount()->EventId, $createOrder);
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/order/search', array('filter[PayerRocId]' => $this->payer->RocId)));
      }
      else
      {
        $this->error = 'Необходимо заполнить все поля данных юр. лиц.';
      }
    }
    $this->getController()->render('create-order', array('orderItems' => $orderItems));
  }

  private function createOrderValidateForm ($data)
  {
    return !empty($data['Name']) && !empty($data['Address']) && !empty($data['INN']) && !empty($data['KPP']) && !empty($data['Phone']) && !empty($data['PostAddress']);
  }
}