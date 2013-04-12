<?php
namespace contact\models\forms;
 
class Address extends \CFormModel
{
  public $CountryId;
  public $RegionId;
  public $CityId;
  public $Street;
  public $House;
  public $Building;
  public $Wing;
  public $Place;
  
  public function rules()
  {
    return array(
      array('Street,House,Building,Wing,Place', 'filter', 'filter' => array('application\components\utility\Texts', 'filterPurify')),
      array('Street,House,Building,Wing,Place', 'safe'), 
      array('CountryId', 'exist', 'className' => '\geo\models\Country', 'attributeName' => 'Id', 'allowEmpty' => true),
      array('CityId', 'exist', 'className' => '\geo\models\City', 'attributeName' => 'Id', 'allowEmpty' => true),
      array('RegionId', 'exist', 'className' => '\geo\models\Region', 'attributeName' => 'Id', 'allowEmpty' => true),
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'CountryId' => \Yii::t('app', 'Страна'),
      'RegionId' => \Yii::t('app', 'Регион'),
      'CityId' => \Yii::t('app', 'Город'),
      'House' => \Yii::t('app', 'Дом'),
      'Building' => \Yii::t('app', 'Строение'),
      'Wing' => \Yii::t('app', 'Корпус'),
      'Street' => \Yii::t('app', 'Улица'),
      'Place' => \Yii::t('app', 'Место'),
    );
  }
}
