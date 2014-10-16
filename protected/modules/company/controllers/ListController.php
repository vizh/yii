<?php
use \company\models\Company;
use \application\components\utility\Paginator;

class ListController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $this->setPageTitle('Компании / RUNET-ID');

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'EmploymentsAll' => [
                'select' => false,
                'together' => true,
                'with' => [
                    'User' => [
                        'select' => false
                    ]
                ]
            ],
            'LinkAddress' => [
                'select' => false,
                'with' => [
                    'Address' => [
                        'select' => false
                    ]
                ]
            ]
        ];
        $criteria->addCondition('"EmploymentsAll"."EndYear" IS NULL AND "t"."Name" != \'\'');
        $criteria->group  = '"t"."Id"';
        $criteria->order  = 'Count("EmploymentsAll".*) DESC, "t"."Name" ASC';

        $filter = new \company\models\form\ListFilterForm();
        $request = \Yii::app()->getRequest();
        $filter->attributes = $request->getParam('Filter');
        if ($request->getParam('Filter') !== null && $filter->validate())
        {
            foreach ($filter->attributes as $attr => $value)
            {
                if (!empty($value))
                {
                    switch($attr)
                    {
                        case 'CityId':
                            $criteria->addCondition('"Address"."CityId" = :CityId');
                            $criteria->params['CityId'] = $value;
                            break;

                        case 'Query':
                            $criteria->addCondition('to_tsvector("t"."Name") @@ plainto_tsquery(:Query)');
                            $criteria->params['Query'] = $value;
                            break;
                    }
                }
            }
        }
        $allCompanyCount = Company::model()->count($criteria);
        $paginator = new Paginator($allCompanyCount);
        $criteria->mergeWith($paginator->getCriteria());
        $companies = Company::model()->findAll($criteria);
        $companies = \CHtml::listData($companies, 'Id', null);


        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', array_keys($companies));
        $criteria->with = array(
            'LinkEmails.Email',
            'LinkSite.Site',
            'LinkPhones.Phone',
            'LinkAddress.Address.City',
            'Employments'
        );

        foreach (Company::model()->findAll($criteria) as $company)
        {
            $companies[$company->Id] = $company;
        }

        $this->bodyId = 'companies-list';
        $this->setPageTitle(\Yii::t('app', 'Компании'));
        $this->render('index', array(
            'companies' => $companies,
            'filter' => $filter,
            'paginator' => $paginator,
        ));
    }
}
