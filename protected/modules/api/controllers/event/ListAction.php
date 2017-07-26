<?php

namespace api\controllers\event;

use api\components\Action;
use event\models\Event;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

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
     *              @Param(title="TitleSearch",   mandatory="N",                             description="Поисковая строка для поиска по названию мероприятий."),
     *              @Param(title="Type",          mandatory="N",                             description="Фильтр по идентификатору или названию типа мероприятия."),
     *              @Param(title="City",          mandatory="N",                             description="Фильтр по названию города проведения мероприятия."),
     *              @Param(title="Year",          mandatory="N", defaultValue="текущий год", description="Год."),
     *              @Param(title="VisibleOnMain", mandatory="N",                             description="Главные новости, или новости с установленным флагом отображения на титульной странице.")
     *          },
     *          response=@Response(body="['{$EVENT}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $events = Event::model()
            ->byDate($this->getRequestParam('Year', date('Y')))
            ->with(['LinkSite', 'Type', 'LinkAddress' => ['with' => ['Address' => ['with' => ['City' => ['with' => ['Region', 'Country']]]]]]])
            ->byVisible();

        if ($this->hasRequestParam('Type')) {
            $type = $this->getRequestParam('Type');
            if (is_numeric($type)) {
                $events->byTypeId($type);
            } else {
                $events->byTypeName($type);
            }
        }

        if ($this->hasRequestParam('City')) {
            $events->byTown($this->getRequestParam('City'));
        }

        if ($this->hasRequestParam('TitleSearch')) {
            $events->byTitleSearch($this->getRequestParam('TitleSearch'));
        }

        if ($this->hasRequestParam('VisibleOnMain')) {
            $events->byVisibleOnMain($this->getRequestParamBool('VisibleOnMain'));
        }

        $events = $events->findAll();

        $result = [];
        foreach ($events as $event) {
            $result[] = $this
                ->getDataBuilder()
                ->createEvent($event);
        }

        $this->setResult($result);
    }
}
