<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class InfoAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Информация о мероприятии",
     *     description="Информация о мероприятии.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/info",
     *          body="",
     *          params={
     *              @Param(title="FromUpdateTime", description="(Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.")
     *          },
     *          response=@Response(body="['Объект EVENT']")
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