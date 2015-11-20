<?php

use application\components\utility\Paginator;
use buduguru\models\Course;

class CourseController extends \application\components\controllers\PublicMainController
{
    public function actionList()
    {
        $this->setPageTitle('Курсы / RUNET-ID');

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."DateStart"';

        $paginator = new Paginator(Course::model()->count($criteria));

        $criteria->mergeWith($paginator->getCriteria());
        $criteria->order = '"t"."Id" DESC';

        $this->render('list', [
            'courses' => Course::model()->findAll($criteria),
            'paginator' => $paginator
        ]);
    }
}
