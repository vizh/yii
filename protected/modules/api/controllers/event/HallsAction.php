<?php
namespace api\controllers\event;

use api\components\Action;
use event\models\section\Hall;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class HallsAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Залы",
     *     description="Список залов мероприятия.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/halls'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/halls",
     *          body="",
     *          params={
     *              @Param(title="FromUpdateTime", description="(Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.")
     *          },
     *          response=@Response(body="['{$HALL}']")
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $model = Hall::model()->byEventId($this->getEvent()->Id);

        if ($this->hasRequestParam('FromUpdateTime'))
            $model->byUpdateTime($this->getRequestedDate());

        $withDeleted = $request->getParam('WithDeleted', false);
        if (!$withDeleted) {
            $model->byDeleted(false);
        }

        $halls = $model->findAll(['order' => 't."Order"']);
        $result = [];
        foreach ($halls as $hall) {
            $result[] = $this->getDataBuilder()->createSectionHall($hall);
        }
        $this->setResult($result);
    }
}