<?php
class EventController extends \convert\components\controllers\Controller
{
  public function actionIndex()
  {
    $events = $this->queryAll('SELECT * FROM `Event` ORDER BY `EventId`');
  }
}