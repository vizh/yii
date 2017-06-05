<?php
namespace api\controllers\professionalinterest;

use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class DeleteAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Interests",
     *     title="Удаление",
     *     description="Удаляет у частника мероприятия 'проф. интерес'",
     *     request=@Request(
     *          method="GET",
     *          url="/professionalinterest/dell",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="Идентификатор участника."),
     *              @Param(title="ProfessionalInterestId", mandatory="Y", description="Идентификатор 'проф. интереса'.")
     *          },
     *          response=@Response( body="{'Success': true}" )
     *     )
     * )
     */
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId');
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user !== null) {
            $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
            if ($participant === null) {
                throw new \api\components\Exception(202, [$runetId]);
            }
        } else {
            throw new \api\components\Exception(202, [$runetId]);
        }

        $professionalInterestId = \Yii::app()->getRequest()->getParam('ProfessionalInterestId');
        $link = \user\models\LinkProfessionalInterest::model()->byUserId($user->Id)->byProfessionalInterestId($professionalInterestId)->find();
        if ($link !== null) {
            $link->delete();
        }
        $this->setSuccessResult();
    }
}