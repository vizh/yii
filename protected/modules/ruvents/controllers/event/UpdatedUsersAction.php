<?php
namespace ruvents\controllers\event;


class UpdatedUsersAction extends \ruvents\components\Action
{
  public function run()
  {
    ini_set("memory_limit", "512M");

    $request = \Yii::app()->getRequest();
    $fromUpdateTime = $request->getParam('FromUpdateTime', null);
    $byPage = $request->getParam('Limit', 200);
    $needCustomFormat = $request->getParam('CustomFormat', false) == '1';
    if ($fromUpdateTime === null)
    {
      throw new \ruvents\components\Exception(321);
    }
    $fromUpdateTime = date('Y-m-d H:i:s', strtotime($fromUpdateTime));

    $pageToken = $request->getParam('PageToken', null);
    $offset = 0;
    if ($pageToken !== null)
    {
      $offset = $this->getController()->parsePageToken($pageToken);
    }

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Participants' => array('on' => '"Participants"."EventId" = :EventId', 'params' => array(
        'EventId' => $this->getEvent()->Id
      ), 'together' => false),
      'Employments' => array('together' => false),
      'Employments.Company' => array('together' => false),
      'LinkPhones.Phone' => array('together' => false)
    );
    $criteria->order = '"t"."Id" ASC';
    $criteria->addCondition('"t"."UpdateTime" > :UpdateTime');
    $criteria->params['UpdateTime'] = $fromUpdateTime;
    $criteria->addCondition('"t"."Id" IN (SELECT "EventParticipant"."UserId" FROM "EventParticipant" WHERE "EventParticipant"."EventId" = '.$this->getEvent()->Id.')');

    $criteria->limit = $byPage;
    $criteria->offset = $offset;
    $users = \user\models\User::model()->findAll($criteria);
    $idList = array();
    foreach ($users as $user)
    {
      $idList[] = $user->Id;
    }
    $orderItems = $this->getOrderItems($idList);
    $badgesCount = $this->getBadgesCount($idList);
    $externalList = $this->getExternalIds($idList);

    $result = array();
    $result['Users'] = array();
    foreach ($users as $user)
    {
      $this->getDataBuilder()->createUser($user);
      $this->getDataBuilder()->buildUserEmployment($user);
      $this->getDataBuilder()->buildUserPhone($user);
      $resultUser = $this->getDataBuilder()->buildUserEvent($user);

      if (isset($orderItems[$user->Id]))
      {
        $resultUser->PaidItems = array();
        foreach ($orderItems[$user->Id] as $item)
        {
          $order = $this->getDataBuilder()->createOrderItem($item);

          if ($needCustomFormat)
          {
            $customOrder = (object) array(
              'OrderItemId' => $item->Id,
              'ProductId' => $order->Product->ProductId,
              'ProductTitle' => $order->Product->Title,
              'Price' => $order->Product->Price
            );

            if ($order->PromoCode) $customOrder->PromoCode = $order->PromoCode;
            if ($order->PayType) $customOrder->PayType = $order->PayType;
            if ($order->Product->Manager) $customOrder->ProductManager = $order->Product->Manager;
            if ($item->Product->ManagerName == 'RoomProductManager') $customOrder->Lives = $item->Product->getManager()->Hotel;

            $order = $customOrder;
          }

          $resultUser->PaidItems[] = $order;
        }
      }
      $resultUser->BadgeCount = isset($badgesCount[$user->Id]) ? $badgesCount[$user->Id] : 0;
      $resultUser->ExternalId = isset($externalList[$user->Id]) ? $externalList[$user->Id] : null;
      $result['Users'][] = $resultUser;
    }

    if (sizeof($users) == $byPage)
    {
      $result['NextPageToken'] = $this->getController()->getPageToken($offset + $byPage);
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  private function getBadgesCount($idList)
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."UserId"', $idList);
    /** @var $badges \ruvents\models\Badge[] */
    $badges = \ruvents\models\Badge::model()
        ->byEventId($this->getEvent()->Id)->findAll($criteria);
    $badgesCount = array();
    foreach ($badges as $badge)
    {
      if (!isset($badgesCount[$badge->UserId]))
      {
        $badgesCount[$badge->UserId] = 0;
      }
      $badgesCount[$badge->UserId]++;
    }
    return $badgesCount;
  }

  private function getOrderItems($idList)
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."OwnerId"', $idList);
    $criteria->addCondition('"t"."ChangedOwnerId" IS NULL');
    $criteria->addInCondition('"t"."ChangedOwnerId"', $idList, 'OR');

    $orderItems = \pay\models\OrderItem::model()
        ->byEventId($this->getEvent()->Id)->byPaid(true)->findAll($criteria);

    $result = array();
    foreach ($orderItems as $item)
    {
      $ownerId = $item->ChangedOwnerId === null ? $item->OwnerId : $item->ChangedOwnerId;
      $result[$ownerId][] = $item;
    }
    return $result;
  }

  private function getExternalIds($idList)
  {
    $result = [];
    $apiAccount = \api\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($apiAccount != null)
    {
      $criteria = new \CDbCriteria();
      $criteria->addInCondition('t."UserId"', $idList);

      $externals = \api\models\ExternalUser::model()
        ->byPartner($apiAccount->Role)->findAll($criteria);
      foreach ($externals as $external)
      {
        $result[$external->UserId] = $external->ShortExternalId;
      }
    }
    return $result;
  }
}