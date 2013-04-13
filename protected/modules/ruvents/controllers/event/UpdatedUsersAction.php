<?php
namespace ruvents\controllers\event;


class UpdatedUsersAction extends \ruvents\components\Action
{
  public function run()
  {
    ini_set("memory_limit", "512M");

    $request = \Yii::app()->getRequest();
    $fromUpdateTime = $request->getParam('FromUpdateTime', null);
    if ($fromUpdateTime === null)
    {
      throw new \ruvents\components\Exception(321);
    }
    $fromUpdateTime = date('Y-m-d H:i:s', strtotime($fromUpdateTime));

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Participants' => array('together' => true, 'select' => false)
    );
    $criteria->addCondition('"Participants"."EventId" = :EventId');
    $criteria->params['EventId'] = $this->getEvent()->Id;
    $criteria->addCondition('"t"."UpdateTime" > :UpdateTime');
    $criteria->params['UpdateTime'] = $fromUpdateTime;
    $criteria->order = '"t"."UpdateTime" ASC';
    $criteria->group = '"t"."Id"';
    $criteria->limit = 200;

    $users = \user\models\User::model()->findAll($criteria);
    $idList = array();
    foreach ($users as $user)
    {
      $idList[] = $user->Id;
    }

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Participants' => array('on' => '"Participants"."EventId" = :EventId', 'params' => array(
        'EventId' => $this->getEvent()->Id
      )),
      'Employments' => array('together' => false),
      'Employments.Company' => array('together' => false),
      'LinkPhones.Phone'
    );
    $criteria->order = '"t"."UpdateTime" ASC';
    $criteria->addInCondition('"t"."Id"', $idList);
    $users = \user\models\User::model()->findAll($criteria);
    $orderItems = $this->getOrderItems($idList);
    $badgesCount = $this->getBadgesCount($idList);

    $result = array();
    $result['Users'] = array();
    $lastUpdateTime = null;
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
          $resultUser->PaidItems[] = $this->getDataBuilder()->createOrderItem($item);
        }
      }
      $resultUser->BadgeCount = isset($badgesCount[$user->Id]) ? $badgesCount[$user->Id] : 0;
      $result['Users'][] = $resultUser;
      $lastUpdateTime = $user->UpdateTime;
    }
    $result['LastUpdateTime'] = $lastUpdateTime;

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
}