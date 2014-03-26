<?php
namespace pay\controllers\juridical;

class CreateAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    $this->getController()->setPageTitle('Выставление счета  / ' .$this->getEvent()->Title . ' / RUNET-ID');

    if ($this->getAccount()->OrderLastTime !== null && $this->getAccount()->OrderLastTime < date('Y-m-d H:i:s'))
    {
      throw new \CHttpException(404);
    }

    $order = new \pay\models\Order();
    $unpaidItems = $order->getUnpaidItems($this->getUser(), $this->getEvent());

    $form = new \pay\models\forms\Juridical();
    if (sizeof($unpaidItems) > 0)
    {
      $request = \Yii::app()->getRequest();
      $form->attributes = $request->getParam(get_class($form));
      if ($request->getIsPostRequest() && $request->getParam(get_class($form)) !== null && $form->validate())
      {
        $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::Juridical, $form->attributes);
        $this->getController()->redirect(\Yii::app()->createUrl('/pay/order/index', array('orderId' => $order->Id, 'hash' => $order->getHash())));
      }
    }

    $this->getController()->render('create', array(
      'form' => $form,
      'unpaidItems' => $unpaidItems
    ));
  }
}
