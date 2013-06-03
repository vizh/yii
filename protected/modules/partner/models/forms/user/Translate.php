<?php
namespace partner\models\forms\user;

class Translate extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $FatherName;
  
  public $Company;
  
  public function rules()
  {
    return array(
      array('FirstName, LastName', 'required'),
      array('FatherName, Company', 'safe')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'FirstName'  => \Yii::t('app', 'Имя'),
      'LastName'   => \Yii::t('app', 'Фамилия'),
      'FatherName' => \Yii::t('app', 'Отчество'),
      'Company'    => \Yii::t('app', 'Компания'),
    );
  }
}
