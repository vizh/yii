<?php
namespace api\controllers\event;

use api\components\Exception;
use event\models\Participant;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response as ApiResponse;
use nastradamus39\slate\annotations\ApiAction;

/**
 * Изменение статуса на мероприятии
 * параметры: RunetId -участник RoleId - id новой роли
 * Class ChangeroleAction
 * @package api\controllers\event
 */
class ChangeroleAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Смена роли",
     *     description="Меняет роль заданному пользователю.",
     *     samples={
    @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/changerole?RunetId=678047&RoleId=6'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/changerole",
     *          body="",
     *          params={
     *              @Param(title="RoleId",  description="Id новой роли.", mandatory="Y"),
     *              @Param(title="RunetId", description="RunetId пользователя.", mandatory="Y")
     *          },
     *          response=@ApiResponse(body="{'Success': true}")
     *      )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');

        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if (empty($user)) {
            throw new Exception(202, [$runetId]);
        }

        $role = \event\models\Role::model()->findByPk($roleId);
        if (empty($role)) {
            throw new Exception(302, [$roleId]);
        }

        $participant = Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->getEvent()->Id)
            ->find();
        if (empty($participant)) {
            throw new Exception(302, [$participant]);
        }

        $participant->RoleId = $roleId;
        if ($participant->save()) {
            $this->setSuccessResult();
        } else {
            $this->setResult(['Error' => true]);
        }
    }
}