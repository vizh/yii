<?php
namespace ruvents\controllers\product;


class ChangepaidAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $fromRunetId = $request->getParam('FromRunetId', null);
    $toRunetId = $request->getParam('ToRunetId', null);
    $orderItemIdList = $request->getParam('orderItemIdList', '');
    $orderItemIdList = explode(',', $orderItemIdList);

    $event = $this->getEvent();
    $fromUser = \user\models\User::model()->byRunetId($fromRunetId)->find();
    if ($fromUser === null)
    {
      throw new \ruvents\components\Exception(202, array($fromRunetId));
    }
    $toUser = \user\models\User::model()->byRunetId($toRunetId)->find();
    if ($toUser === null)
    {
      throw new \ruvents\components\Exception(202, array($toRunetId));
    }

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."Id"', $orderItemIdList);

    $orderItems = \pay\models\OrderItem::model()
        ->byEventId($event->Id)->findAll($criteria);

    if (sizeof($orderItems) == 0)
    {
      throw new \ruvents\components\Exception(409, array(implode(',', $orderItemIdList)));
    }
    if ( sizeof($orderItems) < sizeof($orderItemIdList))
    {
      $errorId = array();
      foreach ($orderItemIdList as $id)
      {
        $flag = true;
        foreach($orderItems as $item)
        {
          if ($item->Id == $id)
          {
            $flag = false;
            break;
          }
        }
        if ($flag)
        {
          $errorId[] = $id;
        }
      }
      throw new \ruvents\components\Exception(409, array(implode(',', $errorId)));
    }
    $this->checkOwned($orderItems, $fromUser);
    $this->checkProducts($orderItems, $toUser);

    $detailLog = $this->getDetailLog()->createBasic();
    foreach ($orderItems as $item)
    {
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', $item->Id, 0));
      $detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', 0, $item->Id));
      $item->changeOwner($toUser);
    }

    $this->getDetailLog()->UserId = $fromUser->Id;
    $this->getDetailLog()->save();

    $detailLog->UserId = $toUser->Id;
    $detailLog->save();

    echo json_encode(array('Success' => true));
  }



  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param \user\models\User $user
   * @throws \ruvents\components\Exception
   * @return void
   */
  private function checkOwned($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if (($item->ChangedOwnerId !== null && $item->ChangedOwnerId != $user->Id) ||
          ($item->ChangedOwnerId === null && $item->OwnerId != $user->Id))
      {
        $errorId[] = $item->Id;
      }
    }
    if (!empty($errorId))
    {
      throw new \ruvents\components\Exception(413, array(implode(',', $errorId)));
    }
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param \user\models\User $user
   * @throws \ruvents\components\Exception
   * @return void
   */
  private function checkProducts($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if (!$item->Product->getManager()->checkProduct($user))
      {
        $errorId[] = $item->Id;
      }
    }
    if (!empty($errorId))
    {
      throw new \ruvents\components\Exception(414, array(implode(',', $errorId)));
    }
  }
}