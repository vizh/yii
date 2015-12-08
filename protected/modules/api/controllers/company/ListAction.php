<?php
namespace api\controllers\company;

use api\components\Action;
use api\components\Exception;
use company\models\Company;

class ListAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $query = $request->getParam('Query');
        $code  = $request->getParam('Code');
        $raec  = $request->getParam('Raec');

        $model = Company::model();

        $criteria = $this->getCriteria();

        if (!empty($query)) {
            if (is_numeric($query)) {
                $model->byId($query);
            } else {
                $model->bySearch($query);
            }
        } elseif (!empty($code)) {
            $model->byCode($code);
        }

        if ($raec !== null) {
            $model->byRaec((bool) $raec);
        }

        $result = ['Companies' => []];

        $builder = $this->getDataBuilder();
        $companies = $model->ordered()->findAll($criteria);
        foreach ($companies as $company) {
            $builder->createCompany($company);
            $result['Companies'][] = $builder->buildCompanyRaecUser($company);
        }

        if (count($companies) == $criteria->limit) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $criteria->limit);
        }
        $this->setResult($result);
    }

    /**
     * @return \CDbCriteria
     * @throws Exception
     */
    private function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['ActiveRaecUsers', 'LinkEmail', 'LinkAddress', 'LinkPhones', 'LinkRaecClusters'];

        $request = \Yii::app()->getRequest();
        $limit = $request->getParam('MaxResults', $this->getMaxResults());
        $criteria->limit = min($limit, $this->getMaxResults());

        $token = $request->getParam('PageToken');
        $criteria->offset = $token === null ? 0 : $this->getController()->parsePageToken($token);
        return $criteria;
    }
}