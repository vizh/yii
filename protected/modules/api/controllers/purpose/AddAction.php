<?php
namespace api\controllers\purpose;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class AddAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Добавление цели мероприятия",
     *     description="Добавляет новую цель посещения мероприятия пользователем.'",
     *     request=@Request(
     *          method="GET",
     *          url="/purpose/add",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="Идентификатор участника."),
     *              @Param(title="PurposeId", mandatory="Y", description="Идентификатор цели посещения мероприятия.")
     *          },
     *          response=@Response( body="{'Success': true}" )
     *     )
     * )
     */
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
    $criteria = new \CDbCriteria();
    $criteria->with = ['Purpose'];
    $criteria->addCondition('"Purpose"."Visible"');
    if (!\event\models\LinkPurpose::model()->byEventId($this->getEvent()->Id)->byPurposeId($purposeId)->exists($criteria))
      throw new \api\components\Exception(801, [$purposeId]);

    $link = \user\models\LinkEventPurpose::model()
      ->byEventId($this->getEvent()->Id)->byPurposeId($purposeId)->byUserId($user->Id)->find();

    if ($link == null)
    {
      $link = new \user\models\LinkEventPurpose();
      $link->EventId = $this->getEvent()->Id;
      $link->UserId = $user->Id;
      $link->PurposeId = $purposeId;
      $link->save();
    }

    $this->setSuccessResult();
  }
}