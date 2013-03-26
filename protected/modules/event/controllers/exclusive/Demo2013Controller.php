<?php
class Demo2013Controller extends \application\components\controllers\PublicMainController
{
  private function registerResources()
  {
    $assetPath = \Yii::getPathOfAlias('pay.assets.js.cabinet');
    \Yii::app()->clientScript->registerScriptFile(
      \Yii::app()->assetManager->publish($assetPath.'/register.js')
    );
  }


  public function actionAlley($eventIdName, $productId)
  {
    
    $request = \Yii::app()->getRequest();
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    $product = \pay\models\Product::model()->byEventId($event->Id)->findByPk($productId);
    if ($product == null
      || $this->getProductHash($product, $request->getParam('T')) !== $request->getParam('Hash'))
    {
      echo $this->getProductHash($product, $request->getParam('T'));
      throw new CHttpException(404);
    }
    $products = array($product);
    
    $this->registerResources();
    
    $orderForm = new \pay\models\forms\OrderForm(); 
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($request->getIsPostRequest() && $orderForm->validate())
    {
      if (sizeof($orderForm->Items) !== 1)
      {
        $orderForm->addError('Items', \Yii::t('app', 'Для добавления товара нужно указать только одного получателя'));
      }
      else
      {
        $owner = user\models\User::model()->byRunetId($orderForm->Items[0]['RunetId'])->find();
        if ($owner == null)
        {
          $orderForm->addError('Items', \Yii::t('app', 'Вы не указали получателя товара'));
        }
      }

      if (!$orderForm->hasErrors())
      {
        $criteria = new \CDbCriteria();
        $criteria->with = array(
          'Activations' => array('together' => true)
        );
        $criteria->condition = '"Activations"."UserId" = :UserId AND "t"."ProductId" = :ProductId';
        $criteria->params['UserId'] = $owner->Id;
        $criteria->params['ProductId'] = $product->Id;
        $coupon = \pay\models\Coupon::model()->find($criteria);
        if ($coupon !== null)
        {
          try
          {
            $product->getManager()->createOrderItem(\Yii::app()->user->getCurrentUser(), $owner);
          }
          catch(\pay\components\Exception $e)
          {
            $orderForm->addError('Items', $e->getMessage());
          }
        }
        else
        {
          $orderForm->addError('Items', \Yii::t('app', 'Для возможности оплаты товара нужно обязательно активировать промо-код.'));
        }
      }
      
      if (!$orderForm->hasErrors())
      {
        $this->redirect(
          $this->createUrl('/pay/cabinet/index', array('eventIdName' => $event->IdName))
        );
      }
    }
    
    $this->bodyId = 'event-register';
    $this->render('pay.views.cabinet.register', array(
      'orderForm' => $orderForm,
      'registerForm' => new \user\models\forms\RegisterForm(),
      'products' => $products,
      'event' => $event
    ));
  }
  
  
  public function actionExibitionLinks($eventIdName)
  {
    if (\Yii::app()->request->getParam('key') !== '2qDWLBUAxH')
    {
      throw new CHttpException(404);
    }
    
    $event = event\models\Event::model()->byIdName($eventIdName)->find();
    $products = pay\models\Product::model()->byEventId($event->Id)->byPublic(false)->findAll();
    $this->render('exibition-links', array(
      'event' => $event,
      'products' => $products
    ));
  }

  public function getProductHash($product, $timestamp = null)
  {
    if ($timestamp == null)
    {
      $timestamp = time();
    }
    return substr(md5($timestamp.$product->Id),25,30);
  }
  
//  public function actions()
//  {
//    return array(
//      'alley' => '/demo2013/alleyaction'  
//    );
//  }
}
