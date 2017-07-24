<?php

use buduguru\models\Course;
use event\models\Event;
use job\models\Job;

class DefaultController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $this->setPageTitle('RUNET-ID');

        $date = getdate();
        $criteria = new CDbCriteria();
        $criteria->order = '"t"."VisibleOnMain" DESC, "t"."StartYear", "t"."StartMonth", "t"."StartDay", "t"."EndYear", "t"."EndMonth", "t"."EndDay"';
        $criteria->limit = 3;
        $events = Event::model()
            ->byVisible(true)
            ->byFromDate($date['year'], $date['mon'], $date['mday'])
            ->findAll($criteria);

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" DESC';
        $criteria->limit = 4;

        $this->render('index', [
            'events' => $events,
            'courses' => Course::model()->findAll($criteria),
            'jobs' => Job::model()->findAll($criteria)
        ]);
    }
}