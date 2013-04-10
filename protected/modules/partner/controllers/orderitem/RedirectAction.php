<?php
namespace partner\controllers\orderitem;

class RedirectAction extends \partner\components\Action
{
  public function run($orderItemId = '')
  {
    $this->getController()->setPageTitle('Перенос заказа');
    $this->getController()->initActiveBottomMenu('redirect');

    $orderItem = \pay\models\OrderItem::model()->findByPk((int)$orderItemId);
    $changedOwner = null;
    
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $runetId = $request->getParam('Query');

      $changedOwner = \user\models\User::model()->byRunetId($runetId)->find();
      
      if ($orderItem === null || $orderItem->Product->EventId !== $this->getEvent()->Id)
      {
        \Yii::app()->user->setFlash('error', 'Заказ не найден');
      }
      else if ($changedOwner === null)
      {
        \Yii::app()->user->setFlash('error', 'Пользователь не найден');
      }
      else
      {
        if ($orderItem->changeOwner($changedOwner))
        {
          $this->getController()->redirect(
            $this->getController()->createUrl('/partner/orderitem/index', array(
                'filter[OrderItemId]' => $orderItem->Id
              )
            )
          );
        }
        \Yii::app()->user->setFlash('error', 'Произошла ошибка при переносе заказа');
      }
    }

    $this->getController()->render('redirect', array(
      'orderItem' => $orderItem,
      'changedOwner' => $changedOwner
    ));
  }
}