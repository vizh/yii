<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class PurposesAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Цели мероприятия",
     *     description="Цели мероприятия.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/purposes'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/purposes",
     *          params={},
     *          response=@Response(body="[ { 'Id': 3, 'Title': 'Выступление с докладом' }, { 'Id': 2, 'Title': 'Обмен опытом' },
    { 'Id': 1, 'Title': 'Образование / получение новых знаний' }, { 'Id': 4, 'Title': 'Хантинг' }]")
     *     )
     * )
     */
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Purpose'];
        $criteria->order = '"Purpose"."Title" ASC';
        $criteria->addCondition('"Purpose"."Visible"');
        $links = \event\models\LinkPurpose::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

        $result = [];
        /** @var \event\models\LinkPurpose $link */
        foreach ($links as $link) {
            $result[] = $this->getDataBuilder()->createEventPuprose($link->Purpose);
        }
        $this->setResult($result);
    }
}
