<?php
namespace partner\controllers\order;

class EditAction extends \partner\components\Action
{
  private $order;
  private $request;

  public function run($orderId)
  {
    $this->order = \pay\models\Order::model()->byEventId($this->getEvent()->Id)->byPaid(false)->findByPk($orderId);
    if ($this->order == null || !$this->order->getIsBankTransfer())
      throw new \CHttpException(404);

    $form = new \pay\models\forms\Juridical();
    $this->request = \Yii::app()->getRequest();
    if ($this->request->getIsAjaxRequest())
    {
      $this->processAjax();
      \Yii::app()->end();
    }

    if ($this->request->getIsPostRequest())
    {
      $form->attributes = $this->request->getParam(get_class($form));
      if ($form->validate())
      {
        $this->order->OrderJuridical->setAttributes($form->getAttributes(), false);
        $this->order->OrderJuridical->save();
        \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Счет успешно сохранен!'));
        $this->getController()->refresh();
      }
    }
    else
    {
      foreach ($this->order->OrderJuridical->getAttributes() as $attr => $value)
      {
        if (property_exists($form, $attr))
          $form->$attr = $value;
      }
    }


    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findAll();
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование счета'));
    $this->getController()->render('edit', ['form' => $form, 'products' => $products, 'order' => $this->order]);
  }


  private function processAjax()
  {
    $method = $this->request->getParam('Method');
    $method = 'ajaxMethod'.$method;
    if (method_exists($this, $method))
    {
      $result = $this->$method();
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    else
    {
      throw new \CHttpException(404);
    }
    exit();
  }

  private function ajaxMethodGetItemList()
  {
    $result = [];
    foreach ($this->order->ItemLinks as $itemLink)
    {
      if (!$itemLink->OrderItem->Paid && !$itemLink->OrderItem->Deleted)
      {
        $item = new \stdClass();
        $item->Id = $itemLink->OrderItem->Id;
        $item->Owner = $itemLink->OrderItem->Owner->getFullName();
        $item->Product = $itemLink->OrderItem->Product->Title;
        $item->Price = $itemLink->OrderItem->getPriceDiscount().' '.\Yii::t('app', 'руб.');
        $result[] = $item;
      }
    }
    return $result;
  }

  private function ajaxMethodDeteleItem()
  {
    $orderItemId = $this->request->getParam('OrderItemId');
    $orderItem = \pay\models\OrderItem::model()->byDeleted(false)->byPaid(false)->byEventId($this->getEvent()->Id)->findByPk($orderItemId);
    $result = new \stdClass();
    $result->success = false;
    if ($orderItem !== null)
    {
      $link = \pay\models\OrderLinkOrderItem::model()->byOrderId($this->order->Id)->byOrderItemId($orderItem->Id)->find();
      $link->delete();
      $orderItem->delete();
      $result->success = true;
    }
    else
    {
      $result->error = true;
      $result->message = \Yii::t('app', 'Заказ не найден!');
    }
    return $result;
  }

  private function ajaxMethodCreateItem()
  {
    $result = new \stdClass();
    $result->success = false;
    $request = \Yii::app()->getRequest();

    $error = null;
    $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findByPk($request->getParam('ProductId'));
    if ($product == null)
    {
      $error = \Yii::t('app', 'Продукт не найден!');
    }

    $owner = \user\models\User::model()->byRunetId($request->getParam('RunetId'))->find();
    if ($owner == null)
    {
      $error = \Yii::t('app', 'Пользователь не найден!');
    }

    if ($error == null)
    {
      try
      {
        $orderItem = $product->getManager()->createOrderItem($this->order->Payer, $owner);
        $link = new \pay\models\OrderLinkOrderItem();
        $link->OrderId = $this->order->Id;
        $link->OrderItemId = $orderItem->Id;
        $link->save();
      }
      catch(\pay\components\Exception $e)
      {
        $error = $e->getMessage();
      }
    }

    if ($error == null)
    {
      $result->success = true;
    }
    else
    {
      $result->error = true;
      $result->message = $error;
    }
    return $result;
  }
} 