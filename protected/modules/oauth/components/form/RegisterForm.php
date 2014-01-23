<?php
namespace oauth\components\form;

class RegisterForm extends \CFormModel
{
  private $account = null;

  public $LastName;
  public $FirstName;
  public $FatherName;
  public $Email;
  public $CompanyId;
  public $Company;
  public $Address;
  public $Phone;


  public function __construct(\api\models\Account $account)
  {
    parent::__construct('');
    $this->account = $account;
    $this->Address = new \contact\models\forms\Address();
    if ($account->showPhoneFieldOnRegistration())
    {
      $formPhoneScenario = $account->RequestPhoneOnRegistration == \application\models\RequiredStatus::Required ? \contact\models\forms\Phone::ScenarioOneFieldRequired : \contact\models\forms\Phone::ScenarioOneField;
      $this->Phone = new \contact\models\forms\Phone($formPhoneScenario);
    }
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

    if ($this->account->showPhoneFieldOnRegistration())
    {
      $this->Phone->attributes = \Yii::app()->getRequest()->getParam(get_class($this->Phone));
      if (!$this->Phone->validate())
      {
        foreach ($this->Phone->getErrors() as $messages)
        {
          $this->addError('Phone', $messages[0]);
        }
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
      if ($field == 'Address' || $field == 'Phone')
        continue;
      $attributes[$field] = $purifier->purify($value);
    }
    $this->attributes = $attributes;
    return parent::beforeValidate();
  }

  /**
   * @return \api\models\Account|null
   */
  public function getAccount()
  {
    return $this->account;
  }
}
