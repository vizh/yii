<?php
namespace user\models\forms\edit;

class Contacts extends \CFormModel
{
  public $Email;
  public $Site;
  public $PrimaryPhone;
  public $Phones = array();
  public $Accounts = array();
  public $Address;

  public function __construct($scenario = '')
  {
    $this->Address = new \contact\models\forms\Address();
    return parent::__construct($scenario);
  }
  
  public function validate($attributes = null, $clearErrors = true)
  {
    $this->Address->attributes = \Yii::app()->request->getParam(get_class($this->Address));
    if (!$this->Address->validate())
    {
      foreach ($this->Address->getErrors() as $messages)
      {
        $this->addError('Address', $messages[0]);
      }
    }
    return parent::validate($attributes, false);
  }
  
  public function rules()
  {
    return array(
      ['PrimaryPhone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false, 'criteria' => array('condition' => '"t"."Id" != :UserId AND "t"."Visible"', 'params' => array('UserId' => \Yii::app()->user->getId()))),
      array('Email, PrimaryPhone', 'required'),
      array('Site', 'url', 'allowEmpty' => true),
      array('Phones', 'filter', 'filter' => array($this, 'filterPhones')),
      array('Accounts', 'filter', 'filter' => array($this, 'filterAccounts')),
      ['PrimaryPhone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => ['condition' => '"t"."Id" != :UserId', 'params' => ['UserId' => \Yii::app()->user->getId()]]]
    );
  }
 
  public function attributeLabels()
  {
    return array(
      'Site' => \Yii::t('app', 'Сайт'),
      'PrimaryPhone' => \Yii::t('app', 'Основной телефон'),
      'Phones' => \Yii::t('app', 'Дополнительные телефоны'),
      'Accounts' => \Yii::t('app', 'Аккаунты в социальных сетях'),
      'Address' => \Yii::t('app', 'Город')
    );
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
  
  
  public function filterAccounts($accounts)
  {
    $accountTypeList = array();
    foreach ($accounts as $account)
    {
      if (in_array($account->TypeId, $accountTypeList))
      {
        $this->addError('Account', \Yii::t('app', 'Ошибка в заполнении поля {attribute}. Для одной соц. сети может быть указан только один аккаунт.', array('{attribute}' => $this->getAttributeLabel('Accounts'))));
        break;
      }
      $accountTypeList[] = $account->TypeId;
      
      if (!$account->validate())
      {
        $this->addError('Accounts', \Yii::t('app', 'Ошибка в заполнении поля {attribute}.', array('{attribute}' => $this->getAttributeLabel('Accounts'))));
        break;
      }
    }
    return $accounts;
  }

  

  public function setAttributes($values, $safeOnly = true)
  {
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
    
    if (isset($values['Accounts']))
    {
      foreach ($values['Accounts'] as $value)
      {
        $form = new \contact\models\forms\ServiceAccount();
        $form->attributes = $value;
        $this->Accounts[] = $form;
      }
      unset($values['Accounts']);
    }
    parent::setAttributes($values, $safeOnly);
  }

  public function getPhoneTypeData()
  {
    $types = array(
     \contact\models\PhoneType::Mobile => \Yii::t('app', 'Мобильный'),
     \contact\models\PhoneType::Work => \Yii::t('app', 'Рабочий')
    );
    return $types;
  }
  
  public function getAccountTypeData()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Title" ASC';
    $types = \contact\models\ServiceType::model()->byVisible()->findAll($criteria);
    return \CHtml::listData($types, 'Id', 'Title');
  }
}
