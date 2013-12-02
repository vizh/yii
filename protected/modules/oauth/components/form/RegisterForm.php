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
  public $Address;

  public function __construct($scenario = '')
  {
    parent::__construct($scenario);
    $this->Address = new \contact\models\forms\Address();
  }


  public function attributeLabels()
  {
    return array(
      'LastName' => \Yii::t('app', 'Фамилия'),
      'FirstName' => \Yii::t('app', 'Имя'),
      'FatherName' => \Yii::t('app', 'Отчество'),
      'Email' => \Yii::t('app', 'Электронная почта'),
      'Company' => \Yii::t('app', 'Компания'),
      'City' => \Yii::t('app', 'Город'),
    );
  }

  public function afterValidate()
  {
    $this->Address->attributes = \Yii::app()->getRequest()->getParam(get_class($this->Address));
    if (!$this->Address->validate())
    {
      foreach ($this->Address->getErrors() as $messages)
      {
        $this->addError('Address', $messages[0]);
      }
    }
  }

  public function rules()
  {
    return array(
      array('FirstName, LastName, Email', 'required'),
      array('Email', 'email'),
      array('Email', 'uniqueEmailValidate'),
      array('FatherName, CompanyId, Company', 'safe')
    );
  }
  
  public function uniqueEmailValidate($attribute, $params)
  {
    $value = trim($this->$attribute);
    if (!empty($value))
    {
      if (!\user\models\User::model()->byEmail($value)->byVisible(true)->exists())
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
      if ($field == 'Address')
        continue;
      $attributes[$field] = $purifier->purify($value);
    }
    $this->attributes = $attributes;
    return parent::beforeValidate();
  }
  

}
