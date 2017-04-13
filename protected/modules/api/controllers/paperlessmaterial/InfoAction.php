<?php
namespace api\controllers\paperlessmaterial;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use paperless\models\Material;

class InfoAction extends \api\components\Action
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
     *              @Param(title="Id", mandatory="Y", description="Идентификатор материала.")
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('Id');

        $material = Material::model()->findByPk($id);

        $this->setResult($this->getAccount()->getDataBuilder()->createPaperlessMaterial($material));
    }
}