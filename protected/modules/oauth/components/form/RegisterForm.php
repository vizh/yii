<?php
namespace oauth\components\form;

class RegisterForm extends \CFormModel
{
  public $LastName;
  public $FirstName;
  public $FatherName;
  public $Email;
  public $CompanyId;
  public $Company;
  public $CityId;
  public $City;

  public function attributeLabels()
  {
    return array(
      'LastName' => 'Фамилия',
      'FirstName' => 'Имя',
      'FatherName' => 'Отчество',
      'Email' => 'Электронная почта',
      'Company' => 'Компания',
      'City' => 'Город',
    );
  }
  
  public function rules()
  {
    return array(
      array('FirstName, LastName, Email', 'required'),
      array('Email', 'email'),
      array('Email', 'uniqueEmailValidate'),
      array('FatherName, CompanyId, Company, CityId, City', 'safe')
    );
  }
  
  public function uniqueEmailValidate($attribute, $params)
  {
    $value = trim($this->$attribute);
    if (!empty($value))
    {
      if (\user\models\User::model()->byEmail($value)->count() == 0)
      {
        return true;
      }
      $this->addError($attribute, 'Пользователь с таким Email уже существует.');
    }
    return false;
  }
  
  protected function beforeValidate()
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements' => array()  
    );
    $attributes = $this->attributes;
    foreach ($this->attributes as $field => $value)
    {
      $attributes[$field] = $purifier->purify($value);
    }
    $this->attributes = $attributes;
    return parent::beforeValidate();
  }
  

}
