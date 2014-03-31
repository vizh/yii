<?php
namespace partner\controllers\order;

/**
 * Class CreateAction
 *
 * Действие для создания счетов
 *
 * @package partner\controllers\order
 */
class CreateAction extends \partner\components\Action
{
  use ProcessOrderItems;

  /** @var \user\models\User */
  public $payer;

  /**
   * @var int Runet ID плательщика
   */
  protected $payerRunetId;

  public function run()
  {
    $this->registerResources();
    $request = \Yii::app()->getRequest();

    $this->getController()->setPageTitle('Выставление счета');
    $this->getController()->initActiveBottomMenu('createbill');

    $this->payerRunetId = \Yii::app()->getRequest()->getParam('payerRunetId');
    if ($request->isAjaxRequest)
      $this->processOrderItemsByAjax();

    $form = new \pay\models\forms\Juridical();
    if ($request->isPostRequest)
      $this->createOrder($form);

    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->excludeRoomManager()->findAll();
    $this->getController()->render('create', [
      'payerRunetId' => $this->payerRunetId,
      'products' => $products,
      'form' => $form
    ]);
  }

  /**
   * Создает счет
   * @param \pay\models\forms\Juridical $form
   * @throws \CHttpException
   */
  private function createOrder(\pay\models\forms\Juridical $form)
  {
    if (empty($this->payerRunetId))
      throw new \CHttpException(400, 'Не задан обязательный параметр!');

    $payer = \user\models\User::model()->byRunetId($this->payerRunetId)->find();

    $form->attributes = \Yii::app()->request->getParam(get_class($form));
    if ($form->validate())
    {
      $order = new \pay\models\Order();
      $order->create($payer, $this->getEvent(), \pay\models\OrderType::Juridical, $form->attributes);
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/order/view', ['orderId' => $order->Id]));
    }

    // Переходим к шагу 3
    \Yii::app()->getClientScript()->registerScript('move-to-step-3', '$(\'a[name="step2"]\').click(); $(\'a[name="step3"]\').click();', \CClientScript::POS_READY);
  }

  /**
   * @return array Список заказов
   * @throws \CException
   */
  protected function ajaxMethodGetItemsList()
  {
    if (empty($this->payerRunetId))
      throw new \CHttpException(400, 'Не задан обязательный параметр!');

    $payer = \user\models\User::model()->byRunetId($this->payerRunetId)->find();
    $orderItems = \pay\components\collection\Finder::create($this->getEvent()->Id, $payer->Id)
        ->getUnpaidFreeCollection();

    $result = [];
    foreach ($orderItems->getIterator() as $item)
    {
      $item = $item->getOrderItem();
      if (!$item->Paid && !$item->Deleted)
      {
        $_item = new \stdClass();
        $_item->Id = $item->Id;
        $_item->Owner = $item->Owner->getFullName();
        $_item->Product = $item->Product->Title;
        $_item->Price = $item->getPriceDiscount().' '.\Yii::t('app', 'руб.');
        $result[] = $_item;
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

    if ($orderItem->delete())
      $result->success = true;

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
        $payer = \user\models\User::model()->byRunetId($this->payerRunetId)->find();
        $product->getManager()->createOrderItem($payer, $owner);
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