<?php
namespace partner\controllers\order;

/**
 * Class EditAction
 *
 * Действие для редактирования счетов
 *
 * @package partner\controllers\order
 */
class EditAction extends \partner\components\Action
{
  use ProcessOrderItems;

  /**
   * @var \pay\models\Order
   */
  protected $order;

  public function run($orderId)
  {
    $this->registerResources();

    $this->order = \pay\models\Order::model()->byEventId($this->getEvent()->Id)->byPaid(false)->findByPk($orderId);
    if ($this->order == null || !$this->order->getIsBankTransfer())
      throw new \CHttpException(404);

    $form = new \pay\models\forms\Juridical();
    $request = \Yii::app()->getRequest();
    if ($request->getIsAjaxRequest())
      $this->processOrderItemsByAjax();

    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
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

    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->excludeRoomManager()->findAll();
    $this->getController()->render('edit', ['form' => $form, 'products' => $products, 'order' => $this->order]);
  }

  /**
   * @return array Список заказов
   */
  protected function ajaxMethodGetItemsList()
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

  /**
   * Удаляет заказ
   * @return \stdClass
   */
  protected function ajaxMethodDeleteItem()
  {
    $orderItemId = \Yii::app()->request->getParam('OrderItemId');
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

  /**
   * Создает заказ
   * @return \stdClass
   */
  protected function ajaxMethodCreateItem()
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