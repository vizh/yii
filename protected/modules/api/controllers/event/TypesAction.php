<?php
namespace api\controllers\event;

use api\components\Action;
use event\models\Type;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class TypesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Типы мероприятия",
     *     description="Список возможных типов мероприятий. Используются для фильтрации в методе eventList.",
     *     samples={
     *          @Sample(lang="shell",code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/types'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/types",
     *          params={
     *              @Param(title="EventCounts", type="логический", defaultValue="N", description="Если установлен в true, то отображается количество мероприятий каждого типа участия.")
     *          },
     *     )
     * )
     */
    public function run()
    {
        $types = Type::model();

        if ($this->getRequestParamBool('EventCounts')) {
            $types->with('EventsCount');
        }

        $types = $types->findAll();

        $this->setResult($types);
    }
}
