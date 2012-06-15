<?php
/**
 * @property int $CountryId
 * @property string $Name
 */
class GeoCountry extends CActiveRecord
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
   * @return GeoCountry[]
   */
  public static function GetAll()
  {
    $country = GeoCountry::model();
    $criteria = new CDbCriteria();
    $criteria->order = 'Priority DESC, Name';
    return $country->findAll($criteria);
  }
}