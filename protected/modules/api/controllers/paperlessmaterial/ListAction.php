<?php
namespace api\controllers\paperlessmaterial;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use paperless\models\Material;

class ListAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Paperlessmaterial",
     *     title="Список материалов",
     *     description="Список материалов.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/paperlessmaterial/list'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/paperlessmaterial/list",
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
        $materials = Material::model()->findAll();

        $result = array();
        foreach ($materials as $material)
        {
            $result[] = $this->getDataBuilder()->createPaperlessMaterial($material);
        }

        $this->setResult($result);
    }
}