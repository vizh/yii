<?php
namespace company\models\form;
class Edit extends \CFormModel
{
  public $Name;
  public $FullName;
  public $FullInfo;
  public $Address;
  public $Phones = [];
  public $Emails = [];
  public $Site;
  public $Logo;
  public $OGRN;
  
  public function __construct($scenario = '')
  {
    $this->Address = new \contact\models\forms\Address();
    return parent::__construct($scenario);
  }
  
  public function rules()
  {
    return [
      ['Name, FullName', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
      ['Name', 'required'],
      ['Site', 'url', 'allowEmpty' => true],
      ['Phones', 'filter', 'filter' => [$this, 'filterPhones']],
      ['Emails', 'filter', 'filter' => [$this, 'filterEmails']],
      ['FullInfo', 'filter', 'filter' => [$this, 'filterFullInfo']],
      ['Logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true],
      ['OGRN', 'numerical', 'integerOnly' => true],
      ['OGRN', 'length', 'is' => 13]
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'Logo' => \Yii::t('app', 'Логотип'),
      'Name' => \Yii::t('app', 'Коммерческое название компании'),
      'FullName' => \Yii::t('app', 'Юридическое название компании'),
      'FullInfo' => \Yii::t('app', 'Информация о компании'),
      'Site' => \Yii::t('app', 'Адрес сайта'),
      'Address' => \Yii::t('app', 'Адрес'),
      'Phones' => \Yii::t('app', 'Номера телефонов'),
      'Emails' => \Yii::t('app', 'Эл. почта'),
      'OGRN' => \Yii::t('app', 'ОГРН'),
    ];
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
