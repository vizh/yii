<?php
namespace partner\controllers\order;

class CreateAction extends \partner\components\Action
{

  public $payer;
  public $error;

  public function run()
  {
    $this->getController()->setPageTitle('Выставление счета');
    $this->getController()->initBottomMenu('createbill');

    $payerRocId = \Yii::app()->getRequest()->getParam('payerRocId');
    if (!empty($rocId))
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

    if (\Yii::app()->request->getIsPostRequest() && !empty($createOrder))
    {

      $payerRocId = (int) $createOrder['Payer']['RocId'];
      if ($payerRocId != 0)
      {
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/order/create/', array('payerRocId' => $payerRocId)));
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
    if ( !isset ($this->Payer))
    {
      $this->stepIndex();
      $this->view->Error = 'Плательщик не найден';
      return;
    }

    $view = new View();
    $view->SetTemplate('stepCreateOrder');

    $view->Payer = $this->Payer;
    $allOrderItems = OrderItem::GetByEventId($this->Payer->UserId, $this->Account->EventId);
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

    if ( empty ($orderItems))
    {
      $this->stepIndex();
      $this->view->Error = 'На пользователя с rocID: '. $this->Payer->RocId .' нет ни одного заказа';
      return;
    }
    else
    {
      $view->OrderItems = $orderItems;
    }

    if ( yii::app()->request->getIsPostRequest()
      && isset ($_REQUEST['CreateOrder']))
    {
      $createOrder = Registry::GetRequestVar('CreateOrder');
      if ( $this->createOrderValidateForm($createOrder))
      {
        Order::CreateOrder($this->Payer, $this->Account->EventId, $createOrder);
        Lib::Redirect(
          RouteRegistry::GetUrl('partner', 'order', 'search') .'?filter[PayerRocId]='. $this->Payer->RocId
        );
      }
      else
      {
        $this->view->Error = 'Необходимо заполнить все поля данных юр. лиц.';
      }
    }


    $this->view->Form = $view;
  }

  private function createOrderValidateForm ($data)
  {
    return !empty($data['Name']) && !empty($data['Address']) && !empty($data['INN']) && !empty($data['KPP']) && !empty($data['Phone']) && !empty($data['PostAddress']);
  }
}