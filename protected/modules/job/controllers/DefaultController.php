<?php

class DefaultController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $this->setPageTitle('Работа / RUNET-ID');

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Category',
            'Position',
            'Company'
        ];
        $criteria->order = '"t"."CreationTime"';

        $request = \Yii::app()->getRequest();
        $filter = new \job\models\form\ListFilterForm();
        $filter->attributes = $request->getParam('Filter');
        if ($filter->validate()) {
            foreach ($filter->attributes as $attribute => $value) {
                if (!empty($value)) {
                    switch ($attribute) {
                        case 'CategoryId':
                            $criteria->addCondition('"Category"."Id" = :CategoryId');
                            $criteria->params['CategoryId'] = $value;
                            break;

                        case 'PositionId':
                            $criteria->addCondition('"Position"."Id" = :PositionId');
                            $criteria->params['PositionId'] = $value;
                            break;

                        case 'SalaryFrom':
                            $criteria->addCondition('"t"."SalaryFrom" >= :SalaryFrom OR ("t"."SalaryFrom" IS NULL AND "t"."SalaryTo" >= :SalaryFrom)');
                            $criteria->params['SalaryFrom'] = $value;
                            break;

                        case 'Query':
                            $criteria->addCondition('to_tsvector("t"."Title") @@ plainto_tsquery(:Query)');
                            $criteria->params['Query'] = $value;
                            break;
                    }
                }
            }
        }

        $allJobCount = \job\models\Job::model()->count($criteria);

        $paginator = new \application\components\utility\Paginator($allJobCount);
        $paginator->perPage = \Yii::app()->params['JobPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $criteria->order = '"t"."Id" DESC';
        $jobs = \job\models\Job::model()->findAll($criteria);

        $jobUp = null;
        if ($paginator->page == 1 && !empty($jobs)) {
            $criteria->with = ['Job.Category', 'Job.Position', 'Job.Company'];
            $criteria->condition = str_replace('"t".', '"Job".', $criteria->condition);
            $criteria->addCondition('"t"."StartTime" <= :Date AND ("t"."EndTime" >= :Date OR "t"."EndTime" IS NULL)');
            $criteria->params['Date'] = date('Y-m-d H:i:s');
            $jobUp = \job\models\JobUp::model()->find($criteria);
        }
        $this->bodyId = 'jobs-page';
        $this->render('index', [
            'filter' => $filter,
            'jobs' => $jobs,
            'jobUp' => $jobUp,
            'paginator' => $paginator
        ]);
    }
}

?>
