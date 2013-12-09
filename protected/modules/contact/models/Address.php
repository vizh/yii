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
 * @property string $Place
 * @property string $GeoPoint
 *
 * @property \geo\models\Country $Country
 * @property \geo\models\Region $Region
 * @property \geo\models\City $City
 */
class Address extends \application\models\translation\ActiveRecord
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

  /**
   * @return array
   */
  public function getGeoPointCoordinates()
  {
    if ($this->GeoPoint == null)
    {
      $this->setGeoPointCoordinates();
      $this->save();
    }
    return explode(',', $this->GeoPoint);
  }

  /**
   * @return float
   */
  public function getLatitude()
  {
    return $this->getGeoPointCoordinates()[0];
  }

  /**
   * @return float
   */
  public function getLongitude()
  {
    return $this->getGeoPointCoordinates()[1];
  }

  /**
   *
   */
  private function setGeoPointCoordinates()
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, 'http://geocode-maps.yandex.ru/1.x/?'.http_build_query(array('format' => 'json', 'geocode' => $this->__toString())));
    $yaGeocoderResponse = json_decode(curl_exec($curl));
    if (!empty($yaGeocoderResponse->response->GeoObjectCollection->featureMember))
    {
      $position = $yaGeocoderResponse->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
      $coordinates = explode(' ', $position);
      $this->GeoPoint = $coordinates[1].','.$coordinates[0];
    }
  }
  
  
  public function getShort()
  {
    $address = [];

    if (!empty($this->City->Name))
      $address[] = \Yii::t('app', 'г.').' '. $this->City->Name;

    if (!empty($this->Street))
      $address[] = $this->Street;

    if (!empty($this->House))
      $address[] .= \Yii::t('app', 'д.').' '.$this->House;

    if (!empty($this->Building))
      $address[] .= \Yii::t('app', 'стр.').' '.$this->Building;

    if (!empty($this->Wing))
      $address[] .= \Yii::t('app', 'корпус').' '.$this->Wing;

    if (!empty($this->Apartment))
      $address[] .= \Yii::t('app', 'кв. ').' '.$this->Apartment;

    return implode(', ', $address);
  }
  
  public function __toString()
  {
    $address = $this->getShort();

    if (!empty($this->Place))
    {
      if (!empty($address))
        $address .= ', ';

      $address .= $this->Place;
    }

    return $address;
  }

  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return array('Street', 'House', 'Place');
  }
}