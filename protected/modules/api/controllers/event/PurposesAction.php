<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class PurposesAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Цели мероприятия",
     *     description="Цели мероприятия.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/purposes",
     *          body="",
     *          params={},
     *          response=@Response(body="{[]}")
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
