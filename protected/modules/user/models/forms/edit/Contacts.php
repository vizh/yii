<?php
namespace user\models\forms\edit;

class Contacts extends \CFormModel
{
  public $Email;
  public $Site;
  public $Phones = array();
  public $Accounts = array();
  
  public function rules()
  {
    return array(
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false, 'criteria' => array('condition' => '"t"."Id" != :UserId', 'params' => array('UserId' => \Yii::app()->user->getId()))),
      array('Email', 'required'),
      array('Site', 'url', 'allowEmpty' => true),
      array('Phones', 'filter', 'filter' => array($this, 'filterPhones')),
      array('Accounts', 'filter', 'filter' => array($this, 'filterAccounts'))
    );
  }
 
  public function attributeLabels()
  {
    return array(
      'Site' => \Yii::t('app', 'Сайт'),
      'Phones' => \Yii::t('app', 'Телефоны'),
      'Accounts' => \Yii::t('app', 'Аккаунты в социальных сетях')
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
        $form = new \contact\models\forms\Phone();
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
    $types = \contact\models\ServiceType::model()->findAll($criteria);
    return \CHtml::listData($types, 'Id', 'Title');
  }
}
