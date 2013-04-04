<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/29/12
 * Time: 6:23 PM
 * To change this template use File | Settings | File Templates.
 */
class ProductController extends \ruvents\components\Controller
{
  public function actions()
  {
    return array(
      'paiditems' => 'ruvents\controllers\product\PaiditemsAction',
      'paiditemslist' => 'ruvents\controllers\product\PaiditemsListAction',
    );
  }

  public function actionChangepaid()
  {
    $request = \Yii::app()->getRequest();
    $fromRocId = $request->getParam('FromRocId', null);
    $toRocId = $request->getParam('ToRocId', null);
    $orderItemIdList = $request->getParam('orderItemIdList', '');
    $orderItemIdList = explode(',', $orderItemIdList);

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }
    $fromUser = \user\models\User::GetByRocid($fromRocId);
    if (empty($fromUser))
    {
      throw new \ruvents\components\Exception(202, array($fromRocId));
    }
    $toUser = \user\models\User::GetByRocid($toRocId);
    if (empty($toUser))
    {
      throw new \ruvents\components\Exception(202, array($toRocId));
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.OrderItemId', $orderItemIdList);

    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()->findAll($criteria);

    if (empty($orderItems))
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
          if ($item->OrderItemId == $id)
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

    $detailLog = $this->detailLog->createBasic();
    foreach ($orderItems as $item)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', $item->OrderItemId, 0));
      $detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', 0, $item->OrderItemId));
      $item->setRedirectUser($toUser);
    }

    $this->detailLog->UserId = $fromUser->UserId;
    $this->detailLog->save();

    $detailLog->UserId = $toUser->UserId;
    $detailLog->save();

    echo json_encode(array('Success' => true));
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param \user\models\User $user
   * @throws ruvents\components\Exception
   * @return void
   */
  private function checkOwned($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if ((!empty($item->RedirectId) && $item->RedirectId != $user->UserId) ||
        (empty($item->RedirectId) && $item->OwnerId != $user->UserId))
      {
        $errorId[] = $item->OrderItemId;
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
   * @throws ruvents\components\Exception
   * @return void
   */
  private function checkProducts($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if (!$item->Product->ProductManager()->CheckProduct($user, $item->GetParamValues()))
      {
        $errorId[] = $item->OrderItemId;
      }
    }
    if (!empty($errorId))
    {
      throw new \ruvents\components\Exception(414, array(implode(',', $errorId)));
    }
  }

}