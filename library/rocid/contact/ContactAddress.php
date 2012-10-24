<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.geo.*');

/**
 * @property int $AddressId
 * @property int $CityId
 * @property string $PostalIndex
 * @property string $Street
 * @property string $House
 * @property string $Apartment
 * @property string $Comment
 * @property int $Primary
 *
 * @property GeoCity $City
 *
 *
 * @method GeoCity City() City(array $params)
 */
class ContactAddress extends CActiveRecord
{
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
    return 'AddressId';
  }
  
  public function relations()
  {
    return array(
      'Users' => array(self::MANY_MANY, 'User', 'Link_User_ContactAddress(UserId, AddressId)'),
      'City' => array(self::BELONGS_TO, 'GeoCity', 'CityId', 'with' => array('Country', 'Region')),
    );
  }

  public function ChangeUser($oldUserId, $newUserId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_User_ContactAddress', array('UserId'=>$newUserId), 'UserId=:OldUserId AND AddressId=:AddressId', array(':OldUserId'=>$oldUserId, ':AddressId'=>$this->AddressId));
  }

  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_Company_ContactAddress', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND AddressId=:AddressId', array(':OldCompanyId'=>$oldCompanyId, ':AddressId'=>$this->AddressId));
  }
  
  /**
  * Возвращает нумерацию дома в формате дом-строение-корпус
  *   
  */
  public function GetHouse()
  {
    return $this->House;
  }
  /**
  * Устанавливает нумерацию дома в формате дом-строение-корпус
  *   
  */
  public function SetHouse($value)
  {
    $this->House = $value;
  }
  
  /**
  * @return GeoCity
  */
  public function GetCity()
  {
    if (isset($this->City))
    {
      return $this->City;
    }
    else
    {
      return null;
    }
  }

  /**
   * [0] - дом, [1] - строение, [2] - корпус
   * @return array
   */
  public function GetHouseParsed()
  {
    return preg_split('/-/', trim($this->House), -1);
  }

  /**
   * [0] - дом, [1] - строение, [2] - корпус
   * @param array $value
   * @return void
   */
  public function SetHouseParsed($value)
  {
    $this->House = $value[0] . '-' . $value[1] . '-' .$value[2];
  }
  
  
  public function __toString() 
  {
    $house = $this->GetHouseParsed();
    $result = $this->City->Country->Name.', г. '.$this->City->Name;
    $result .= (!empty($this->Street) ? ', ул. '.$this->Street : '');
    $result .= (!empty($house[0]) ? ', д. '.$house[0] : '');
    $result .= (!empty($house[1]) ? ', стр. '.$house[1] : '');
    $result .= (!empty($house[2]) ? ', к. '.$house[2] : '');
    return $result;
  }
}
