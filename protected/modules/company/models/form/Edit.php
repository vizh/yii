<?php
namespace company\models\form;
class Edit extends \CFormModel
{
  public $Name;
  public $FullName;
  public $FullInfo;
  public $Address;
  public $Phones = array();
  public $Emails = array();
  public $Site;
  public $Logo;
  
  public function __construct($scenario = '')
  {
    $this->Address = new \contact\models\forms\Address();
    return parent::__construct($scenario);
  }
  
  public function rules()
  {
    return array(
      array('Name, FullName', 'filter', 'filter' => array('application\components\utility\Texts', 'filterPurify')),
      array('Name', 'required'),
      array('Site', 'url', 'allowEmpty' => true),
      array('Phones', 'filter', 'filter' => array($this, 'filterPhones')),
      array('Emails', 'filter', 'filter' => array($this, 'filterEmails')),
      array('FullInfo', 'filter', 'filter' => array($this, 'filterFullInfo')),
      array('Logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),  
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Logo' => \Yii::t('app', 'Логотип'),
      'Name' => \Yii::t('app', 'Название организации'),
      'FullName' => \Yii::t('app', 'Полное название'),
      'FullInfo' => \Yii::t('app', 'Описание'),
      'Site' => \Yii::t('app', 'Адрес сайта'),
      'Address' => \Yii::t('app', 'Адрес'),
      'Phones' => \Yii::t('app', 'Номера телефонов'),
      'Emails' => \Yii::t('app', 'Эл. почта')
    );
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
    
    if (isset($values['Emails']))
    {
      foreach ($values['Emails'] as $value)
      {
        $form = new \contact\models\forms\Email();
        $form->attributes = $value;
        $this->Emails[] = $form;
      }
      unset($values['Emails']);
    }
    
    parent::setAttributes($values, $safeOnly);
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
  
  public function filterEmails($emails)
  {
    $valid = true;
    foreach ($emails as $email)
    {
      if (!$email->validate())
      {
        $valid = false;
      }
    }
    if (!$valid)
    {
      $this->addError('Emails', \Yii::t('app', 'Ошибка в заполнении поля {attribute}.', array('{attribute}' => $this->getAttributeLabel('Emails'))));
    }
    return $emails;
  }
  
  public function filterFullInfo($value)
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements'   => array('a','strong','em','s','ol','li','ul','p'),
      'HTML.AllowedAttributes' => array('href','name','id'),
      'Attr.EnableID' => true
    );
    return $purifier->purify($value);
  }
  
}
