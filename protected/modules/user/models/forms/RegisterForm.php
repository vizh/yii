<?php
namespace user\models\forms;
class RegisterForm extends \CFormModel
{
  public $LastName;
  public $FirstName;
  public $FatherName = '';
  public $Email;
  public $Phone = '';
  public $Company;
  public $Position = '';
  
  public function rules()
  {
    return array(
      array('LastName,FirstName,Email,Company', 'required'),
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false),
      array('FatherName, Phone, Position', 'safe')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'LastName' => \Yii::t('app', 'Фамилия'),
      'FirstName' => \Yii::t('app', 'Имя'),
      'FatherName' => \Yii::t('app', 'Отчество'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'Company' => \Yii::t('app', 'Компания'),
      'Position' => \Yii::t('app', 'Должность')
    );
  }
}
