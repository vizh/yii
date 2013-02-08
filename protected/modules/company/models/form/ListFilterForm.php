<?php
namespace company\models\form;
class ListFilterForm extends \CFormModel
{
  public $City;
  public $Query;
  
  public function getCityList() 
  {
    $cityList = array(
      \Yii::t('app', 'Все города')
    );
    
    $cities = \Yii::app()->db->createCommand()
      ->from(\company\models\Company::model()->tableName().' Company')
      ->selectDistinct('City.Id, City.Name, City.Priority')
      ->join(\company\models\LinkAddress::model()->tableName().' LinkAddress', '"Company"."Id" = "LinkAddress"."CompanyId"')
      ->join(\contact\models\Address::model()->tableName().' Address', '"Address"."Id" = "LinkAddress"."AddressId"')
      ->join(\geo\models\City::model()->tableName().' City', '"City"."Id" = "Address"."CityId"')
      ->order('City.Priority DESC, City.Name ASC')
      ->queryAll();
    
    foreach ($cities as $city)
    {
      $cityList[$city['Id']] = $city['Name'];
    }
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
