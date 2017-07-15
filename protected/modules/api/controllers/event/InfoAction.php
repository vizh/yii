<?php
namespace api\controllers\event;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class InfoAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Информация о мероприятии",
     *     description="Информация о мероприятии.",
     *     samples={
     *          @Sample(lang="shell",code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/info'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/info",
     *          body="",
     *          params={
     *              @Param(title="FromUpdateTime", description="(Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.")
     *          },
     *          response=@Response(body="'{$EVENT}'")
     *     )
     * )
     */
    public function run()
    {
        $this->getDataBuilder()->createEvent($this->getEvent());
        $this->getDataBuilder()->buildEventPlace($this->getEvent());
        $this->getDataBuilder()->buildEventMenu($this->getEvent());

        $this->getDataBuilder()->buildEventStatistics($this->getEvent());

        $result = $this->getDataBuilder()->buildEventFullInfo($this->getEvent());

        $this->setResult($result);
    }
}
