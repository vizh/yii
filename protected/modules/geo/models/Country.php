<?php
namespace geo\models;

/**
 * @property int $CountryId
 * @property string $Name
 */
class Country extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'GeoCountry';
  }
  
  public function primaryKey()
  {
    return 'CountryId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }

  /**
   * @static
   * @return Country[]
   */
  public static function GetAll()
  {
    $country = Country::model();
    $criteria = new \CDbCriteria();
    $criteria->order = 'Priority DESC, Name';
    return $country->findAll($criteria);
  }
}