<?php
namespace oauth\components\form;

class RegisterForm extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $Password;
  public $Email;
  
  public function rules()
  {
    return array(
      array('FirstName, LastName, Email, Password', 'required'),
      array('Email', 'email'),
      array('Email', 'uniqueEmailValidate')
    );
  }
  
  public function uniqueEmailValidate($attribute, $params)
  {
    $value = trim($this->$attribute);
    if (!empty($value))
    {
      if (\user\models\User::GetByEmail($value) == null)
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
  
  public function attributeLabels()
  {
    return array(
      'LastName' => 'Фамилия',
      'FirstName' => 'Имя',
      'Email' => 'Email',
      'Password' => 'Пароль'
    );
  }
}
