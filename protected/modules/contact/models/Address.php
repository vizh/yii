<?php
namespace contact\models;

/**
 * @property int $Id
 * @property int $CountryId
 * @property int $RegionId
 * @property int $CityId
 * @property string $PostCode
 * @property string $Street
 * @property string $House
 * @property string $Building
 * @property string $Wing
 * @property string $Apartment
 *
 * @property \geo\models\Country $Country
 * @property \geo\models\Region $Region
 * @property \geo\models\City $City
 */
class Address extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Address
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactAddress';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Country' => array(self::BELONGS_TO, '\geo\models\Country', 'CountryId'),
      'Region' => array(self::BELONGS_TO, '\geo\models\Region', 'RegionId'),
      'City' => array(self::BELONGS_TO, '\geo\models\City', 'CityId'),
    );
  }
}