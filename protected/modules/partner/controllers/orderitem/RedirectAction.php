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
        $owner = $orderItem->ChangedOwner !== null ? $orderItem->ChangedOwner : $orderItem->Owner;
        if ($orderItem->changeOwner($changedOwner))
        {
          $form = new \partner\models\forms\OrderItemSearch();
          if ($this->changeRelative($orderItem, $owner, $changedOwner))
          {
            $form->Owner = $changedOwner->RunetId;
            $this->getController()->redirect(
              $this->getController()->createUrl('/partner/orderitem/index', array(
                  \CHtml::activeName($form, 'Owner') => $form->Owner,
                  \CHtml::activeName($form, 'Paid') => 1
                )
              )
            );
          }
          else
          {
            $form->OrderItem = $orderItem->Id;
            $this->getController()->redirect(
              $this->getController()->createUrl('/partner/orderitem/index', array(
                  \CHtml::activeName($form, 'OrderItem') => $form->OrderItem
                )
              )
            );
          }
        }
        \Yii::app()->user->setFlash('error', 'Произошла ошибка при переносе заказа');
      }
    }

    $this->getController()->render('redirect', array(
      'orderItem' => $orderItem,
      'changedOwner' => $changedOwner
    ));
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @param \user\models\User $owner
   * @param \user\models\User $newOwner
   *
   * @return bool
   */
  private function changeRelative($orderItem, $owner, $newOwner)
  {
    if ($this->getEvent()->Id == 422)
    {
      if ($orderItem->Product->ManagerName == 'EventProductManager')
      {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."OwnerId" = :OwnerId AND "t"."ChangedOwnerId" IS NULL OR "t"."ChangedOwnerId" = :OwnerId');
        $criteria->params = array(
          'OwnerId' => $owner->Id
        );
        $orderItems = \pay\models\OrderItem::model()->byEventId($this->getEvent()->Id)
            ->byPaid(true)->findAll($criteria);
        foreach ($orderItems as $item)
        {
          if ($item->Product->ManagerName != 'EventProductManager')
          {
            $item->changeOwner($newOwner);
          }
        }
        return true;
      }
    }
    return false;
  }
}