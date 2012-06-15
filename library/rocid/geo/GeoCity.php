<?php
/**
 * @property int $CityId
 * @property int $CountryId
 * @property int $RegionId
 * @property int $Name
 *
 * @property GeoCountry $Country
 * @property GeoRegion $Region
 */
class GeoCity extends CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public static $TableName = 'GeoCity';
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'CityId';
  }
  
  public function relations()
  {
    return array(
      'Country' => array(self::BELONGS_TO, 'GeoCountry', 'CountryId'),
      'Region' => array(self::BELONGS_TO, 'GeoRegion', 'RegionId')
    );
  }

  /**
   * @static
   * @param int $id
   * @return GeoCity|null
   */
  public static function GetById($id)
  {
    $city = GeoCity::model();
    return $city->findByPk($id);
  }

  /**
   * @static
   * @param int $regionId
   * @return GeoCity[]
   */
  public static function GetCityByRegion($regionId)
  {
    $city = GeoCity::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.RegionId = :RegionId';
    $criteria->order = 'Priority DESC, Name';
    $criteria->params = array(':RegionId' => $regionId);
    return $city->findAll($criteria);
  }
  
  /**
  * @return GeoCountry
  */
  public function GetCountry()
  {
    if (isset($this->Country))
    {
      return $this->Country;
    }
    else
    {
      return null;
    }
  }

  /**
  * @desc НАЗВАНИЕ ГОРОДА
  */
  public function GetName()
  {
    return $this->Name;
  }

}