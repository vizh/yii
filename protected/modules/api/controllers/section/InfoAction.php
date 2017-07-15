<?php

namespace api\controllers\section;

use api\components\Action;
use api\components\Exception;
use event\models\section\Section;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class InfoAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Информация о секции",
     *     description="Информация о конкретной секции.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/info?SectionId=4107'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/info",
     *          params={
     *              @Param(title="SectionId", mandatory="Y", description="Идентификатор секции.")
     *          },
     *          response=@Response(body="'{$SECTION}'")
     *     )
     * )
     */
    public function run()
    {
        $sectionId = Yii::app()->getRequest()->getParam('SectionId');

        $section = Section::model()->byDeleted(false)->findByPk($sectionId);
        if ($section === null) {
            throw new Exception(310, [$sectionId]);
        }
        if ($section->EventId != $this->getEvent()->Id) {
            throw new Exception(311);
        }

        $this->setResult($this->getAccount()->getDataBuilder()->createSection($section));
    }
}
