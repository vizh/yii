<?php

class ListController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $filter = new \user\models\forms\admin\ListFilter();

        $models = ['User' => new \user\models\User()];
        $criteries = [
            'User' => new \CDbCriteria(),
            'Companies' => new \CDbCriteria()
        ];
        $criteries['User']->with = ['Settings', 'Employments.Company'];
        $criteries['User']->order = '"t"."CreationTime" DESC';
        $criteries['Companies']->order = '"t"."Id" ASC';
        $criteries['Companies']->with = [
            'Employments' => [
                'with' => ['User'],
                'order' => '"User"."CreationTime" DESC'
            ],
            'Employments.User.Settings'
        ];

        $filter->attributes = \Yii::app()->getRequest()->getParam(get_class($filter));
        if ($filter->validate()) {
            if (!empty($filter->Sort)) {
                $order = explode('_', $filter->Sort);
                $criteries['User']->order = '"t"."'.$order[0].'" '.$order[1];
                $criteries['Companies']->with['Employments']['order'] = '"User"."'.$order[0].'" '.$order[1];
            }

            if (!empty($filter->Query)) {
                if (strstr($filter->Query, '@')) {
                    $criteries['User']->addCondition('"t"."Email" ILIKE :Email');
                    $criteries['User']->params['Email'] = '%'.$filter->Query.'%';
                } elseif (is_numeric($filter->Query)) {
                    $criteries['User']->addCondition('"t"."RunetId" = :RunetId');
                    $criteries['User']->params['RunetId'] = $filter->Query;
                } else {
                    $models['Companies'] = new \company\models\Company();
                    $criteries['User']->mergeWith(\user\models\User::model()->bySearch($filter->Query, null, true, false)->getDbCriteria());
                    $criteries['Companies']->mergeWith(\company\models\Company::model()->bySearch($filter->Query)->getDbCriteria());
                }
            }
        }

        $counts = [];
        foreach ($models as $key => $model) {
            $counts[$key] = $model->count($criteries[$key]);
        }

        $results = [];
        $paginator = new \application\components\utility\Paginator(array_sum($counts));
        $paginator->perPage = $filter->PerPage;
        $offset = $paginator->getOffset();
        $limit = $paginator->perPage;
        $count = 0;
        foreach ($models as $key => $model) {
            $count += $counts[$key];
            if ($count > $offset) {
                $criteries[$key]->limit = $limit;
                $criteries[$key]->offset = $offset;
                $results = array_merge($results, $models[$key]->findAll($criteries[$key]));
                $limit -= sizeof($results);
                $offset = 0;
            } else {
                $offset = $paginator->getOffset() - $counts[$key];
            }

            if ($limit == 0) {
                break;
            }
        }
        $this->render('index', ['results' => $results, 'paginator' => $paginator, 'filter' => $filter]);
    }
}