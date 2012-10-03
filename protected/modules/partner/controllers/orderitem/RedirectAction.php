<?php
namespace partner\controllers\orderitem;

class RedirectAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Перенос заказа');
    $this->getController()->initBottomMenu('redirect');
    
    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/libs/jquery-ui-1.8.16.custom.min.js'), \CClientScript::POS_HEAD);
    $blitzerPath = \Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/css/blitzer');
    $cs->registerCssFile($blitzerPath . '/jquery-ui-1.8.16.custom.css');
    
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $orderItemId = $request->getParam('OrderItemId');
      $rocId = $request->getParam('RocId');
      
      $orderItem = \pay\models\OrderItem::model()->findByPk($orderItemId);
      $redirectUser = \user\models\User::GetByRocid($rocId);
      
      if ($orderItem == null 
        || $orderItem->Product->EventId !== \Yii::app()->partner->getAccount()->EventId)
      {
        \Yii::app()->user->setFlash('error', 'Заказ не найден');
      }
      else if ($redirectUser == null)
      {
        \Yii::app()->user->setFlash('error', 'Пользователь не найден');
      }
      else
      {
        if ($orderItem->setRedirectUser($redirectUser))
        {
          $this->getController()->redirect(
            $this->getController()->createUrl('orderitem/index', array('filter[OrderItemId]' => $orderItem->OrderItemId))
          );
        }
        \Yii::app()->user->setFlash('error', 'Произошла ошибка при переносе заказа');
      }
    }
    $this->getController()->render('redirect', array('orderItem' => $orderItem, 'redirectUser' => $redirectUser));
  }
}