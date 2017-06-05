<?php
namespace catalog\controllers\admin\company;

class IndexAction extends \CAction
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';

        $searchQuery = \Yii::app()->request->getParam('Query', null);
        if (!empty($searchQuery)) {
            $criteria->addCondition('"t"."Title" ILIKE :Query');
            $criteria->params['Query'] = '%'.$searchQuery.'%';
        }

        $companyCountAll = \catalog\models\company\Company::model()->count($criteria);
        $paginator = new \application\components\utility\Paginator($companyCountAll);
        $paginator->perPage = \Yii::app()->params['AdminCatalogCompanyPerPage'];
        $criteria->mergeWith($paginator->getCriteria());

        $companies = \catalog\models\company\Company::model()->findAll($criteria);
        $this->getController()->setPageTitle(\Yii::t('app', 'Список каталога компаний'));
        $this->getController()->render('index', ['companies' => $companies, 'paginator' => $paginator]);
    }
}
