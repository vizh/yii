<?php
namespace contact\models\forms;

class Phone extends \CFormModel
{
  public $CountryCode;
  public $CityCode;
  public $Phone;
  public $Type;
  public $Id = null;
  public $Delete = 0;


  public function rules()
  {
    return array(
      array('CountryCode, CityCode, Phone, Type', 'filter', 'filter' => array('application\components\utility\Texts', 'filterPurify')),
      array('CountryCode, CityCode, Phone, Type', 'required'),
      array('Id, Delete', 'numerical', 'allowEmpty' => true),
      array('CountryCode, CityCode, Phone', 'numerical'),
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'CountryCode' => \Yii::t('app', 'Код страны'),
      'CityCode' => \Yii::t('app', 'Код города'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'Type' => \Yii::t('app', 'Тип телефона')
    );
  }
}
