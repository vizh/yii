<?php
class UtilityController extends \partner\components\Controller 
{
  public function actionSearchCityAjax($term)
  {
    $criteria = new CDbCriteria();
    $criteria->addSearchCondition('t.Name', $term);
    $criteria->limit = 10;
    $cities = \geo\models\City::model()->findAll($criteria);
    
    $result = array();
    if (!empty($cities))
    {
      foreach ($cities as $city)
      {
        $result[] = array('id' => $city->CityId, 'label' => $city->Name);
      }
    }
    echo json_encode($result);
  }
  
  public function actionSearchCompanyAjax($term)
  {
    $criteria = new \CDbCriteria();
    $criteria->addSearchCondition('t.Name', $term);
    $criteria->limit = 10;
    $companies = \company\models\Company::model()->findAll($criteria);
    
    $result = array();
    if (!empty($companies))
    {
      foreach ($companies as $company)
      {
        $result[] = array('id' => $company->CompanyId, 'label' => $company->Name);
      }
    }
    echo json_encode($result);
  }
}

