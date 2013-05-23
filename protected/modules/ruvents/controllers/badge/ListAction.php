<?php
namespace ruvents\controllers\badge;

class ListAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);
    //$partId = $request->getParam('PartId', null);

    //todo: для PhDays
    $partId = $request->getParam('PartId', 7);

    $event = $this->getEvent();
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }

    $badge = \ruvents\models\Badge::model()->byEventId($event->Id)->byUserId($user->Id);
    if (sizeof($event->Parts) > 0)
    {
      /** @var $part \event\models\Part */
      $part = \event\models\Part::model()->findByPk($partId);
      if ($part === null || $part->EventId != $event->Id)
      {
        throw new \ruvents\components\Exception(306, array($partId));
      }

      $badge->byPartId($part->Id);
    }
    else
    {
      $badge->byPartId(null);
    }
    $badges = $badge->with(array('Role', 'User'))->findAll();

    $result = array();
    foreach ($badges as $badge)
    {
      $result[] = $this->getDataBuilder()->createBadge($badge);
    }

    echo json_encode($result);
  }
}
