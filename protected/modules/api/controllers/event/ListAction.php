<?php
namespace api\controllers\event;

use api\components\Action;
use event\models\Event;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class ListAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Список мероприятий",
     *     description="Список мероприятий за указанный год. Если год не указан - выбираются мероприятия за текущий. Каждое мероприятие выводится без статистики.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/list?Year=2017'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/list",
     *          body="",
     *          params={
     *              @Param(title="Year", description="Год.", mandatory="N")
     *          },
     *          response=@Response(body="['{$EVENT}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $year = (int)Yii::app()->getRequest()->getParam('Year', date('Y'));

        $events = Event::model()->byDate($year)->byVisible(true)->findAll();

        $result = [];
        foreach ($events as $event) {
            $result[] = $this->getDataBuilder()->createEvent($event);
        }

        $this->setResult($result);
    }
}
