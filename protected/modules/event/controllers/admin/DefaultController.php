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

        $this->render('list', ['events' => $events, 'paginator' => $paginator]);
    }

    public function actionCreators()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = '"StartYear" >= :StartYear';
        $criteria->params = ['StartYear' => 2014];
        $criteria->order = '"StartYear" DESC, "StartMonth" DESC, "StartDay" DESC';

        $events = \event\models\Event::model()->findAll($criteria);

        $this->render('creators', ['events' => $events]);
    }
}
