<?php
namespace api\controllers\event;

use api\components\Exception;
use api\models\Account;
use event\models\Participant;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

/**
 * Метод только для служебного использования. Позволяет отменить участие
 * на собственных мероприятиях.
 *
 * @package api\controllers\event
 */
class ParticipationCancelAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Отменя участия.",
     *     description="Отмена участия посетителя. Только для создателей мероприятия.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/participationcancel",
     *          body="",
     *          params={
     *              @Param(title="RunetId", description="RunetId пользователя", mandatory="Y")
     *          },
     *          response=@Response(body="{'success':true}")
     *     )
     * )
     */
    public function run()
    {
        if ($this->getAccount()->Role !== Account::ROLE_OWN)
            throw new Exception(104);

        $participation = Participant::model()
            ->byEventId($this->getEvent()->Id)
            ->byUserId($this->getRequestedUser()->Id)
            ->find();

        if ($participation === null)
            throw new Exception(304);

        if ($participation->delete() === false)
            throw new Exception(100, 'Непредвиденная ошибка отмены участия посетителя');

        $this->setSuccessResult();
    }
}
