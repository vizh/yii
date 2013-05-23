<?php
namespace ruvents\controllers\event;

class UnregisterAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);
    //$partId = $request->getParam('PartId', null);

    //todo: phDays
    $partId = $request->getParam('PartId', 7);

    $event = $this->getEvent();
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }

    $participant = \event\models\Participant::model()->byEventId($event->Id)->byUserId($user->Id);
    $part = null;
    if (sizeof($event->Parts) > 0)
    {
      $part = \event\models\Part::model()->findByPk($partId);
      if ($part === null)
      {
        throw new \ruvents\components\Exception(306, array($partId));
      }
      $participant->byPartId($part->Id);
    }
    else
    {
      $participant->byPartId(null);
    }

    $participant = $participant->find();
    if ($participant === null)
    {
      throw new \ruvents\components\Exception(304);
    }

    $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Role', $participant->RoleId, 0));
    if ($part !== null)
    {
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Day', $part->Id, $part->Id));
    }
    $this->getDetailLog()->UserId = $user->Id;
    $this->getDetailLog()->save();

    $participant->delete();
    echo json_encode(array('Success' => true));
  }
}
