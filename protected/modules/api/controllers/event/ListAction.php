<?php
namespace api\controllers\event;

class ListAction extends \api\components\Action
{
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