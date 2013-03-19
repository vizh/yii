<?php
namespace pay\controllers\juridical;

class CreateAction extends \pay\components\Action
{
  public function run()
  {
    $orderItems = \pay\models\OrderItem::getFreeItems(\Yii::app()->user->CurrentUser()->Id, $this->getController()->getEvent()->Id);

    $unpaidItems = array();
    foreach ($orderItems as $item)
    {
      if (!$item->Paid)
      {
        if ($item->Product->getManager()->checkProduct($item->Owner))
        {
          $unpaidItems[] = $item;
        }
        else
        {
          $item->delete();
        }
      }
    }

    $form = new \pay\models\forms\Juridical();
    if (sizeof($unpaidItems) > 0)
    {
      $request = \Yii::app()->getRequest();
      $form->attributes = $request->getParam(get_class($form));
      if ($request->getIsPostRequest() && )
    }







    if ($request->getIsPostRequest()
        && $request->getParam(get_class($orderJuridicalForm)) !== null
        && $orderJuridicalForm->validate())
    {
      $order = \pay\models\Order::CreateOrder(\Yii::app()->user->CurrentUser(), $this->event->EventId, $orderJuridicalForm->attributes);
      $this->redirect('http://pay.rocid.ru/main/juridical/order/'.$order['OrderId'].'/');
    }

    $this->render('juridical', array(
      'event' => $this->event,
      'form' => $orderJuridicalForm
    ));

    $this->getController()->render('create', array(
      'form' => $form,
      'unpaidItems' => $unpaidItems
    ));
  }
}
