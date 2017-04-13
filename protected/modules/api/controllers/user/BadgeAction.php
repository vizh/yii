<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\Participant;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class BadgeAction extends Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Отметка о записи бейджа",
     *     description="Привязывает бейдж к посетителю мероприятия.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/badge",
     *          body="",
     *          params={
     *              @Param(title="RunetId", type="Число", defaultValue="", description="runetid пользователя. Обязателен."),
     *              @Param(title="BadgeId", type="Число", defaultValue="", description="уникальный идентификатор RFID-бейджа. Обязателен.")
     *          },
     *          response=@Response(body="{'Success':true}")
     *     )
     * )
     */
    public function run()
    {
        $participant = Participant::model()
            ->byEventId($this->getEvent()->Id)
            ->byUserId($this->getRequestedUser()->Id)
            ->find();

        if ($participant === null) {
            throw new Exception(304);
        }

        $participant->BadgeId = (int)$this->getRequestParam('BadgeId');
        $participant->save();

        $this->setResult(['Success' => true]);
    }
}
