<?php

class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionList()
  {
    $this->setPageTitle('Список мероприятий');
    $count = \event\models\Event::model()->byVisible(true)->count();
    $paginator = new \application\components\utility\Paginator($count);

    $criteria = $paginator->getCriteria();
    $criteria->order = '"t"."StartYear", "t"."StartMonth", "t"."StartDay", "t"."EndYear", "t"."EndMonth", "t"."EndDay"';
    $events = \event\models\Event::model()->byVisible(true)->findAll();

    $this->render('list', array('events' => $events, 'paginator' => $paginator));
  }
}
