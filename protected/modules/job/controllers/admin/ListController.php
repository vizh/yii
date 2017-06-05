<?php

class ListController extends application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" DESC';
        $jobCountAll = \job\models\Job::model()->count($criteria);
        $paginator = new \application\components\utility\Paginator($jobCountAll);
        $paginator->perPage = \Yii::app()->params['AdminJobPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $jobs = \job\models\Job::model()->findAll($criteria);
        $this->render('index', [
            'jobs' => $jobs,
            'paginator' => $paginator,
        ]);
    }
}
