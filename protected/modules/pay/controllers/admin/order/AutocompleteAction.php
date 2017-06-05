<?php
namespace pay\controllers\admin\order;

use pay\models\OrderJuridical;

class AutocompleteAction extends \CAction
{
    public function run($term)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('to_tsvector("t"."Name") @@ plainto_tsquery(:Company) or "t"."INN" like :INN');
        $criteria->params['Company'] = $term;
        $criteria->params['INN'] = '%'.$term.'%';
        $companies = OrderJuridical::model()->findAll($criteria);

        echo \CJSON::encode(array_unique(array_map(function ($company) {
            return $company->Name;
        }, $companies)));
    }
}