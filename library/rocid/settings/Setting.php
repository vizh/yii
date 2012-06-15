<?php
class Setting extends CActiveRecord
{
  public static $TableName = 'Core_Settings';
  
  /**
  * @param string $className
  * @return User
  */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'SettingId';
  }
  
  public function relations()
  {
    return array(
    );
  }
  
  /**
  * Возвращает Setting из БД, или создает новую - если в БД нет записи с таким именем.
  * 
  * @param string $name
  * @return Setting
  */
  public static function GetSettingByName($name)
  {    
    $setting = Setting::model()->find('Name LIKE :Name', array(':Name'=>$name));
    if ($setting === null)
    {
      $setting = new Setting();
      $setting->SetName($name);      
    }
    return $setting;
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetSettingId()
  {
    return $this->SettingId;
  }
  
  //Name
  public function GetName()
  {
    return $this->Name;
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
  
  //Value
  public function GetValue()
  {
    return $this->Value;
  }
  
  public function SetValue($value)
  {
    $this->Value = $value;
  }
  
  //Description
  public function GetDescription()
  {
    return $this->Description;
  }
  
  public function SetDescription($value)
  {
    $this->Description = $value;
  }
}
