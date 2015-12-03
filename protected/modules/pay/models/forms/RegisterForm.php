<?php
namespace pay\models\forms;

class RegisterForm extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $SecondName;
  public $Company;
  public $Position;
  public $Email;
  public $Phone;
  public $Password;


  public function rules()
  {
    return array(
      array('FirstName, LastName, Email, Password, Company', 'required'),
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email'),
      array('FirstName, LastName, SecondName, Company, Position, Email, Phone', 'filter', 'filter' => array($this, 'filterPurify'))
    );
  }

  public function filterPurify($value)
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements' => array()
    );
    $value = $purifier->purify($value);
    return $value;
  }

  public function attributeLabels()
  {
    return array(
      'FirstName' => \Yii::t('tc2012', 'Имя'),
      'LastName' => \Yii::t('tc2012', 'Фамилия'),
      'SecondName' => \Yii::t('tc2012', 'Отчество'),
      'Company' => \Yii::t('tc2012', 'Компания'),
      'Position' => \Yii::t('tc2012', 'Должность'),
      'Email' => 'Email',
      'Phone' => \Yii::t('tc2012', 'Телефон'),
      'Password' => \Yii::t('tc2012', 'Пароль')
    );
  }
}
