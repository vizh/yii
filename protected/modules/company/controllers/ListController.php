<?php
class ListController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
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
    $page  = \Yii::app()->request->getParam('page', 1);
    if ($page < 1)
    {
      $page = 1;
    }
    $criteria->limit  = \Yii::app()->params['CompanyPerPage'];
    $criteria->offset = ($page - 1) * \Yii::app()->params['CompanyPerPage'];
    
    
    $companies = \company\models\Company::model()->findAll($criteria);
    $this->bodyId = 'companies-list';
    $this->setPageTitle(\Yii::t('app', 'Компании'));
    $this->render('index', array(
      'companies' => $companies,
      'filter' => $filter,
      'allCompanyCount' => $allCompanyCount,
    ));
  }
}
