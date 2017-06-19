<?php
namespace api\controllers\section;

use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class AddFavoriteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Добавление в избранное",
     *     description="Добавление секции в избранное",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/event/section/addFavorite?RunetId=656438&SectionId=4107'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/addFavorite",
     *          params={
     *              @Param(title="RunetId", description="RunetId участника.", mandatory="Y"),
     *              @Param(title="SectionId", description="Идентификатор секции.", mandatory="Y")
     *          },
     *          response=@Response(body="{'Success': 'true'}")
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId');
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user == null) {
            throw new \api\components\Exception(202, [$runetId]);
        }

        $sectionId = $request->getParam('SectionId');
        $section = \event\models\section\Section::model()->byDeleted(false)->findByPk($sectionId);
        if ($section === null) {
            throw new \api\components\Exception(310, [$sectionId]);
        }
        if ($section->EventId != $this->getEvent()->Id) {
            throw new \api\components\Exception(311);
        }

        $section->addToFavorite($user);
        $this->setSuccessResult();
    }
}