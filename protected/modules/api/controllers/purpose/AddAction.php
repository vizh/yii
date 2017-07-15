<?php

namespace api\controllers\purpose;

use api\components\Action;
use api\components\Exception;
use event\models\LinkPurpose;
use event\models\Participant;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use user\models\LinkEventPurpose;
use user\models\User;
use Yii;

class AddAction extends Action
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
        $runetId = Yii::app()->getRequest()->getParam('RunetId');
        $user = User::model()->byRunetId($runetId)->find();
        if ($user !== null) {
            $participant = Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)
                ->find();
            if ($participant === null) {
                throw new Exception(202, [$runetId]);
            }
        } else {
            throw new Exception(202, [$runetId]);
        }

        $purposeId = Yii::app()->getRequest()->getParam('PurposeId');
        $criteria = new \CDbCriteria();
        $criteria->with = ['Purpose'];
        $criteria->addCondition('"Purpose"."Visible"');
        if (!LinkPurpose::model()->byEventId($this->getEvent()->Id)->byPurposeId($purposeId)
            ->exists($criteria)
        ) {
            throw new Exception(801, [$purposeId]);
        }

        $link = LinkEventPurpose::model()
            ->byEventId($this->getEvent()->Id)->byPurposeId($purposeId)->byUserId($user->Id)->find();

        if ($link == null) {
            $link = new LinkEventPurpose();
            $link->EventId = $this->getEvent()->Id;
            $link->UserId = $user->Id;
            $link->PurposeId = $purposeId;
            $link->save();
        }

        $this->setSuccessResult();
    }
}
