<?php
namespace partner\controllers\order;

class CreateAction extends \partner\components\Action
{

  /** @var \user\models\User */
  public $payer;

  protected $payerRunetId;

  public function run()
  {
    $this->getController()->setPageTitle('Выставление счета');
    $this->getController()->initActiveBottomMenu('createbill');

    $this->payerRunetId = \Yii::app()->getRequest()->getParam('payerRunetId');
    if (!empty($this->payerRunetId))
    {
      $this->payer = \user\models\User::model()->byRunetId($this->payerRunetId)->find();
      $this->stepCreateOrder();
    }
    else
    {
      $this->stepIndex();
    }
  }

  private function stepIndex($error = null)
  {
    $this->getController()->render('create-index', [
      'payerRunetId' => $this->payerRunetId,
      'error' => $error
    ]);
  }

  private function stepCreateOrder ()
  {
    if (!isset($this->payer))
    {
      $this->stepIndex('Плательщик не найден');
      return;
    }

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->payer->Id);
    $collection = $finder->getUnpaidFreeCollection();
    if (count($collection) == 0)
    {
      $this->stepIndex('На пользователя с RUNET-ID: '. $this->payer->RunetId .' нет ни одного заказа');
      return;
    }

    $request = \Yii::app()->getRequest();
    $form = new \pay\models\forms\Juridical();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      $order = new \pay\models\Order();
      $order->create($this->payer, $this->getEvent(), \pay\models\OrderType::Juridical, $form->attributes);
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/order/view', ['orderId' => $order->Id]));
    }

    $this->getController()->render('create-order', [
      'collection' => $collection,
      'form' => $form
    ]);
  }
}