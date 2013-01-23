<?php
namespace company\models\form;
class CompanyListFilterForm extends \CFormModel
{
  public $City;
  public $Query;
  
  public function getCityList() 
  {
    $cityList = array(
      \Yii::t('app', 'Все города')
    );
    
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkAddress.Address.City'
    );
    
    return $cityList;
  }
  
  public function rules() 
  {
    return array(
      array('Query', 'safe'),
      array('City', 'numerical')
    );
  }
}
