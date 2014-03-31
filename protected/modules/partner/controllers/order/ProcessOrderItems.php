<?php
namespace partner\controllers\order;

/**
 * Trait ProcessItems
 *
 * Производит обработку заказов
 *
 * @package partner\controllers\order
 */
trait ProcessOrderItems
{
  /**
   * Регистрирует ресурсы для обработки заказов
   * @throws \CException
   */
  protected function registerResources()
  {
    $file = \Yii::getPathOfAlias('partner.assets.js.order.process-order-items').'.js';
    if (!file_exists($file))
      throw new \CException('Файл '.$file.' не найден!');

    \Yii::app()->clientScript->registerScriptFile(
      \Yii::app()->assetManager->publish($file),
      \CClientScript::POS_HEAD
    );
  }

  /**
   * Анализирует AJAX запрос и обрабатывает заказы
   * @throws \CHttpException
   */
  protected function processOrderItemsByAjax()
  {
    $method = \Yii::app()->request->getParam('Method');
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
    \Yii::app()->end();
  }

  /**
   * @return array Список заказов
   */
  protected function ajaxMethodGetItemsList()
  {
    return [];
  }

  /**
   * Удаляет заказ
   * @return \stdClass
   * @throws \CHttpException
   */
  protected function ajaxMethodDeleteItem()
  {
    throw new \CHttpException(500, 'Метод не реализован!');
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