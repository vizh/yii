<?php

namespace api\controllers\purpose;

use api\components\Action;
use api\components\Exception;
use event\models\Participant;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use user\models\LinkEventPurpose;
use user\models\User;
use Yii;

class DeleteAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Удаление цели мероприятия",
     *     description="Удаляет цель посещения мероприятия пользователем.'",
     *     request=@Request(
     *          method="GET",
     *          url="/purpose/delete",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="Идентификатор участника."),
     *              @Param(title="Purpose Id", mandatory="Y", description="Идентификатор цели посещения мероприятия.")
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
        $link = LinkEventPurpose::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)
            ->byPurposeId($purposeId)->find();
        if ($link !== null) {
            $link->delete();
        }
        $this->setSuccessResult();
    }
}
