<?php
namespace api\controllers\company;

use api\components\Action;
use api\components\Exception;
use api\models\Account;
use application\components\CDbCriteria;
use company\models\Company;

class ListAction extends Action
{
    public function run()
    {
        // Данный метод доступен только для собственных мероприятий
        if ($this->getAccount()->Role !== Account::ROLE_OWN) {
            throw new Exception(104);
        }

        // Сейчас возможна работа только с компаниями кластера РАЭК
        if ($this->getRequestParam('Cluster') !== Company::CLUSTER_RAEC) {
            throw new Exception('В данный момент реализована поддержка только кластера РАЭК');
        }

        $model = Company::model();

        if ($this->hasRequestParam('Query')) {
            $model->bySearch($this->getRequestParam('Query'));
        }

        if ($this->hasRequestParam('Code')) {
            $model->byCode($this->getRequestParam('Code'));
        }

        if ($this->hasRequestParam('Cluster')) {
            $model->byCluster($this->getRequestParam('Cluster'));
        }

        $criteria = CDbCriteria::create()
            ->setWith(['ActiveRaecUsers', 'LinkEmail', 'LinkAddress', 'LinkPhones', 'LinkRaecClusters'])
            ->setLimit(min($this->getRequestParam('MaxResults', $this->getMaxResults()), $this->getMaxResults()))
            ->setOffset(0);

        if ($this->hasRequestParam('PageToken')) {
            $criteria->setOffset($this->getController()->parsePageToken($this->getRequestParam('PageToken')));
        }

        $companies = $model
            ->ordered()
            ->findAll($criteria);

        $result = ['Companies' => []];
        foreach ($companies as $company) {
            $result['Companies'][] = $this->getDataBuilder()->createCompany($company);
        }

        if ($criteria->limit === count($companies)) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $criteria->limit);
        }

        $this->setResult($result);
    }
}