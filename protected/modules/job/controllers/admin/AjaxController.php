<?php

class AjaxController extends application\components\controllers\PublicMainController
{
    public function actionSearchCompany($term)
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = 10;
        $criteria->condition = '"t"."Name" ILIKE :Query';
        $criteria->params['Query'] = '%'.$term.'%';
        $result = [];
        $companies = \job\models\Company::model()->findAll($criteria);
        foreach ($companies as $company) {
            $item = new \stdClass();
            $item->Id = $company->Id;
            $item->Name = $company->Name;
            $result[] = $item;
        }
        echo json_encode($result);
    }

    public function actionSearchPosition($term)
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = 10;
        $criteria->condition = '"t"."Title" ILIKE :Query';
        $criteria->params['Query'] = '%'.$term.'%';
        $result = [];
        $positions = \job\models\Position::model()->findAll($criteria);
        foreach ($positions as $position) {
            $item = new \stdClass();
            $item->Id = $position->Id;
            $item->Title = $position->Title;
            $result[] = $item;
        }
        echo json_encode($result);
    }
}
