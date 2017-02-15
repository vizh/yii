<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class ListAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Список мероприятий",
     *     description="Список мероприятий за указанный год. Если год не указан - выбираются мероприятия за текущий.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/list",
     *          body="",
     *          params={
     *              @Param(title="Year", description="Год.", mandatory="N")
     *          },
     *          response=@Response(body="['Объект EVENT']")
     *     )
     * )
     */
  public function run()
  {
    $year = (int)\Yii::app()->getRequest()->getParam('Year', date('Y'));

    $events = \event\models\Event::model()->byDate($year)->byVisible(true)->findAll();

    $result = array();
    foreach ($events as $event)
    {
      $result[] = $this->getDataBuilder()->createEvent($event);
    }

    $this->setResult($result);
  }
}