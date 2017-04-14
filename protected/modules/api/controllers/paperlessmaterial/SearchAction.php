<?php

namespace api\controllers\paperlessmaterial;

use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use paperless\models\Material;

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
            ->findAll();

        $result = [];
        foreach ($materials as $material) {
            $result[] = $this
                ->getDataBuilder()
                ->createPaperlessMaterial($material);
        }

        $this->setResult($result);
    }
}