<?php
namespace partner\controllers\orderitem;

class CreateAction extends \partner\components\Action
{
  public $error;

  public function run()
  {
    $this->getController()->setPageTitle('Добавление заказа');
    $this->getController()->initActiveBottomMenu('create');

    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/libs/jquery-ui-1.8.16.custom.min.js'), \CClientScript::POS_HEAD);

        $blitzerPath = \Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/css/blitzer');
        $cs->registerCssFile($blitzerPath . '/jquery-ui-1.8.16.custom.css');

    $products = \pay\models\Product::model()->findAll('t.EventId = :EventId', array(':EventId' => \Yii::app()->partner->getAccount()->EventId));

    $request = \Yii::app()->request;
    $orderItem = $request->getParam('OrderItem', array());

    $params = array('products' => $products);

    if ($request->getIsPostRequest() && !empty($orderItem))
    {
      $selectedProduct = \pay\models\Product::GetById($orderItem['ProductId']);
      $payer   = \user\models\User::GetByRocid($orderItem['PayerRocId']);
      $owner   = \user\models\User::GetByRocid($orderItem['OwnerRocId']);

      if ( empty ($selectedProduct))
      {
        $this->error = 'Не найден продукт';
      }
      else if ( empty ($payer))
      {
        $this->error = 'Не найден плательщик';
      }
      else if ( empty ($owner))
      {
        $this->error = 'Не найден получатель';
      }

      if ( empty($this->error))
      {
        $orderItemId = $selectedProduct->ProductManager()->CreateOrderItem($payer, $owner)->OrderItemId;
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/orderitem/index',
          array('filter' => array('OrderItemId' => $orderItemId)))
        );
      }
      else
      {
        $params['selectedProduct'] = $selectedProduct;
        $params['payer'] = $payer;
        $params['owner'] = $owner;
      }
    }


    $this->getController()->render('create', $params);
  }
}
