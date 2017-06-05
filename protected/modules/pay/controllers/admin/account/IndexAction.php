<?php
namespace pay\controllers\admin\account;

class IndexAction extends \CAction
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" DESC';
        $criteria->with = ['Event'];
        $searchQuery = \Yii::app()->request->getParam('Query', null);
        if (!empty($searchQuery)) {
            if (is_numeric($searchQuery)) {
                $criteria->addCondition('"Event"."Id" = :Query');
                $criteria->params['Query'] = $searchQuery;
            } else {
                $criteria->addCondition('"Event"."IdName" ILIKE :Query OR "Event"."Title" ILIKE :Query');
                $criteria->params['Query'] = '%'.$searchQuery.'%';
            }
        }

        $accountCountAll = \pay\models\Account::model()->count($criteria);
        $paginator = new \application\components\utility\Paginator($accountCountAll);
        $paginator->perPage = \Yii::app()->params['AdminPayAccountPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $accounts = \pay\models\Account::model()->findAll($criteria);
        $this->getController()->setPageTitle(\Yii::t('app', 'Платежные аккаунты'));
        $this->getController()->render('index', ['accounts' => $accounts, 'paginator' => $paginator]);
    }
}
