<?php
namespace api\controllers\user;


class PurposesAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user !== null)
    {
      $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
      if ($participant === null)
      {
        throw new \api\components\Exception(202, array($runetId));
      }
    }
    else
      throw new \api\components\Exception(202, array($runetId));

    $criteria = new \CDbCriteria();
    $criteria->with = ['Purpose'];
    $criteria->order = '"Purpose"."Title" ASC';
    $links = \user\models\LinkEventPurpose::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->findAll($criteria);
    $result = [];
    /** @var \user\models\LinkEventPurpose $link */
    foreach ($links as $link)
    {
      $result[] = $this->getDataBuilder()->createEventPuprose($link->Purpose);
    }
    $this->setResult($result);
  }
} 