<?php
namespace api\controllers\purpose;


class DeleteAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId');
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user !== null)
    {
      $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
      if ($participant === null)
      {
        throw new \api\components\Exception(202, [$runetId]);
      }
    }
    else
      throw new \api\components\Exception(202, [$runetId]);


    $purposeId = \Yii::app()->getRequest()->getParam('PurposeId');
    $link = \user\models\LinkEventPurpose::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->byPurposeId($purposeId)->find();
    if ($link !== null)
    {
      $link->delete();
    }
    $this->setResult(['Success' => true]);
  }
} 