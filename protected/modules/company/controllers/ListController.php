<?php
class ListController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $this->setPageTitle('Компании / RUNET-ID');

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkEmails.Email',
      'LinkSite.Site', 
      'LinkPhones.Phone',
      'LinkAddress.Address.City',
      'Employments' => array('together' => false)
    );
    
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
    
    $allCompanyCount = \company\models\Company::model()->count($criteria);
    $paginator = new \application\components\utility\Paginator($allCompanyCount);
    $paginator->perPage = \Yii::app()->params['CompanyPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $companies = \company\models\Company::model()->findAll($criteria);
    $this->bodyId = 'companies-list';
    $this->setPageTitle(\Yii::t('app', 'Компании'));
    $this->render('index', array(
      'companies' => $companies,
      'filter' => $filter,
      'paginator' => $paginator,
    ));
  }
}
