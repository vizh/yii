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
    
    $filter = new \company\models\form\CompanyListFilterForm();
    $request = \Yii::app()->getRequest();
    $filter->attributes = $request->getParam(get_class($filter));
    if ($request->getIsPostRequest() && $filter->validate())
    {
      foreach ($filter->attributes as $attr => $value)
      {
        if (!empty($value))
        {
          switch($attr)
          {
            case 'City':
              $criteria->addCondition('"Address"."CityId" = :CityId');
              $criteria->params['CityId'] = $value;
              break;
            
            case 'Query':
              $criteria->addSearchCondition('"t"."Name"', $value);
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
    $criteria->limit  = $page * \Yii::app()->params['CompanyPerPage'];
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
