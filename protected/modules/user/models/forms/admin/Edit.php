<?php
namespace user\models\forms\admin;

class Edit extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $FatherName;

  public $Email;
  public $Phones = [];
  public $Address;

  public $Visible;

  public $Subscribe;

  public $NewPassword;

  public $Employments = [];

  private $formContacts;
  private $formEmployments;
  private $user;

  public function __construct($user, $scenario = '')
  {
    $this->user = $user;
    $this->Address = new \contact\models\forms\Address();
    $this->formContacts = new \user\models\forms\edit\Contacts();
    $this->formEmployments = new \user\models\forms\edit\Employments();
    return parent::__construct($scenario);
  }

  public function rules()
  {
    return [
      ['FatherName, Visible, Subscribe', 'safe'],
      ['Email', 'email'],
      ['Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false, 'criteria' => ['condition' => '"t"."Id" != :UserId AND "t"."Visible"', 'params' => ['UserId' => $this->user->Id]]],
      ['Email', 'required'],
      ['NewPassword', 'length', 'min' => \Yii::app()->params['UserPasswordMinLenght'], 'allowEmpty' => true],
      ['FirstName', 'filter', 'filter' => [$this, 'filterFirstName']],
      ['LastName', 'filter', 'filter' => [$this, 'filterLastName']],
      ['Employments', 'filter', 'filter' => [$this, 'filterEmployments']],
      ['Phones', 'filter', 'filter' => [$this, 'filterPhones']]
    ];
  }

  private $_attributeLabels = null;
  public function attributeLabels()
  {
    if ($this->_attributeLabels == null)
    {
      $this->_attributeLabels = [
        'Visible' => \Yii::t('app', 'Видимый'),
        'Subscribe' => \Yii::t('app', 'Получать рассылки'),
        'NewPassword' => \Yii::t('app', 'Новый пароль'),
        'FirstName' => \Yii::t('app', 'Имя'),
        'LastName' => \Yii::t('app', 'Фамилия'),
        'FatherName' => \Yii::t('app', 'Отчество'),
        'Employments' => \Yii::t('app', 'Места работы')
      ];
      $this->_attributeLabels = array_merge($this->formContacts->attributeLabels(), $this->_attributeLabels);
      $this->_attributeLabels = array_merge($this->formEmployments->attributeLabels(), $this->_attributeLabels);
    }
    return $this->_attributeLabels;
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

  public function setAttributes($values, $safeOnly = true)
  {
    if (isset($values['Employments']))
    {
      foreach ($values['Employments'] as $value)
      {
        $form = new \user\models\forms\Employment();
        $form->attributes = $value;
        $this->Employments[] = $form;
      }
      unset($values['Employments']);
    }

    if (isset($values['Phones']))
    {
      foreach ($values['Phones'] as $value)
      {
        $form = new \contact\models\forms\Phone(\contact\models\forms\Phone::ScenarioOneFieldRequired);
        $form->attributes = $value;
        $this->Phones[] = $form;
      }
      unset($values['Phones']);
    }

    parent::setAttributes($values, $safeOnly);
  }

  public function filterFirstName($value)
  {
    foreach($this->getLocaleList() as $locale)
    {
      if (empty($value[$locale]))
      {
        $this->addError('FirstName', \Yii::t('app', 'Не заполнено поле {field}.', ['{field}' => $this->getAttributeLabel('FirstName')]));
      }
    }
    return $value;
  }

  public function filterLastName($value)
  {
    foreach($this->getLocaleList() as $locale)
    {
      if (empty($value[$locale]))
      {
        $this->addError('LastName', \Yii::t('app', 'Не заполнено поле {field}.', ['{field}' => $this->getAttributeLabel('LastName')]));
      }
    }
    return $value;
  }

  public function filterEmployments($employments)
  {
    $valid = true;
    foreach ($employments as $employment)
    {
      if (!$employment->validate())
      {
        $valid = false;
      }
    }
    if (!$valid)
    {
      $this->addError('Employments', \Yii::t('app', 'Ошибка в заполнении Карьеры.'));
    }
    return $employments;
  }

  public function filterPhones($phones)
  {
    $valid = true;
    foreach ($phones as $phone)
    {
      if (!$phone->validate())
      {
        $valid = false;
      }
    }
    if (!$valid)
    {
      $this->addError('Phones', \Yii::t('app', 'Ошибка в заполнении поля {attribute}.', array('{attribute}' => $this->getAttributeLabel('Phones'))));
    }
    return $phones;
  }

  public function getPhoneTypeData()
  {
    return $this->formContacts->getPhoneTypeData();
  }

  public function getMonthOptions()
  {
    return $this->formEmployments->getMonthOptions();
  }

  public function getYearOptions()
  {
    return $this->formEmployments->getYearOptions();
  }

  public function getLocaleList()
  {
    return \Yii::app()->params['Languages'];
  }
} 