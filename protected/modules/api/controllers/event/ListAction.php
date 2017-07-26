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
     *              @Param(title="CityName",      mandatory="N",                             description="Если указано название города, то отображаются только проходящие в нём мероприятия."),
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
            ->with(['LinkSite', 'LinkAddress' => ['with' => ['Address' => ['with' => ['City' => ['with' => ['Region', 'Country']]]]]]])
            ->byVisible();

        if ($this->hasRequestParam('CityName')) {
            $events->byTown($this->getRequestParam('CityName'));
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
