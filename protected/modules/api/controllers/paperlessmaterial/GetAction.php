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
     *     description="Информация по партнёрскому материалу Paperless.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/paperless/materials/get?MaterialId=1'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/paperless/materials/get",
     *          body="",
     *          params={
     *              @Param(title="MaterialId", mandatory="Y", description="Идентификатор материала.")
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     * )
     */
    public function run()
    {
        $material = Material::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($this->getRequestParam('MaterialId'));

        if ($material === null) {
            throw new Exception(100, 'Запрашиваемый материал не найден в базе текущего мероприятия');
        }

        $result = $this
            ->getAccount()
            ->getDataBuilder()
            ->createPaperlessMaterial($material);

        $this->setResult($result);
    }
}