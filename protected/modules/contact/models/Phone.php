<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $CountryCode
 * @property string $CityCode
 * @property string $Phone
 * @property string $Addon
 * @property string $Type
 */
class Phone extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Phone
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactPhone';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array();
  }

  /**
   * @param string $phone
   */
  public function parsePhone($phone)
  {
    //todo: Сделать нормальный парсер телефона
    $this->Phone = $phone;
  }
  
  public function __toString() 
  {
    $phone = '';
    if (!empty($this->CountryCode))
    {
      $phone .= '+'.$this->CountryCode.' ';
    }

    if (!empty($this->CityCode))
    {
      $phone .= '('.$this->CityCode.') ';
    }

    $phone .= $this->Phone;
    
    if (!empty($this->Addon))
    {
      $phone .= ', '.\Yii::t('app', 'доб.').' '.$this->Addon;
    }
    return $phone;
  }

  /**
   * @param forms\Phone $form
   */
  public function setAttributesFromForm(\contact\models\forms\Phone $form)
  {
    $this->CountryCode = $form->CountryCode;
    $this->CityCode = !empty($form->CityCode) ? $form->CityCode : null;
    $this->Phone = $form->Phone;
    $this->Type = $form->Type;
  }

  /**
   * @return string
   */
  public function getWithoutFormatting()
  {
    $result = $this->CountryCode;
    if (!empty($this->CityCode))
    {
      $result .= $this->CityCode;
    }
    $result .= $this->Phone;
    return $result;
  }
}