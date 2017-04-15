<?php

namespace api\controllers\paperlessmaterial;

use api\components\Exception;
use event\models\Participant;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use application\models\paperless\Material;

class SearchAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Paperlessmaterial",
     *     title="Список материалов",
     *     description="Список партнёрских материалов Paperless.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/paperless/materials/search'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/paperless/materials/search",
     *          body="",
     *          params={
     *              @Param(title="RunetId", mandatory="N", description="RUNET-ID посетителя для выборки доступных ему материалов.")
     *              @Param(title="RoleId", mandatory="N", description="Один или несколько статусов участия на мероприятии для выборки доступных им материалов.")
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $materials = Material::model()
            ->byEventId($this->getEvent()->Id)
            ->byActive()
            ->byVisible();

        if ($this->hasRequestParam('RunetId')) {
            $participant = Participant::model()
                ->byEventId($this->getEvent()->Id)
                ->byUserId($this->getRequestedUser()->Id)
                ->find();

            if ($participant === null) {
                throw new Exception(304);
            }

            $materials->byRoleId($participant->RoleId);
        }

        if ($this->hasRequestParam('RoleId')) {
            $materials->byRoleId($this->getRequestParamArray('RoleId'));
        }

        $materials = $materials->findAll();

        $result = [];
        foreach ($materials as $material) {
            $result[] = $this
                ->getDataBuilder()
                ->createPaperlessMaterial($material);
        }

        $this->setResult($result);
    }
}