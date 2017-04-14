<?php
namespace api\controllers\paperlessmaterial;

use api\components\Exception;
use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use paperless\models\Material;

class GetAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Paperlessmaterial",
     *     title="Информация по материалу",
     *     description="Информация по материалу.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/paperlessmaterial/info?Id=1'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/paperlessmaterial/info",
     *          body="",
     *          params={
     *              @Param(title="MaterialId", mandatory="Y", description="Идентификатор материала.")
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $material = Material::model()
            ->findByPk($this->getRequestParam('MaterialId'));

        if ($material === null) {
            throw new Exception(100, 'Запрашиваемый материал не найден');
        }

        $result = $this
            ->getAccount()
            ->getDataBuilder()
            ->createPaperlessMaterial($material);

        $this->setResult($result);
    }
}