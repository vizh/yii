<?php

use buduguru\models\Course;
use event\models\Event;
use job\models\Job;

class DefaultController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $date = getdate();

        $events = Event::model()
            ->byVisible()
            ->byFromDate($date['year'], $date['mon'], $date['mday'])
            ->orderBy(['"t"."VisibleOnMain"' => SORT_DESC, '"t"."StartYear", "t"."StartMonth", "t"."StartDay", "t"."EndYear", "t"."EndMonth", "t"."EndDay"'])
            ->limit(3)
            ->findAll();

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