<?php
namespace event\models\forms;
class Create extends \CFormModel
{
  public $ContactName;
  public $ContactPhone;
  public $ContactEmail;
  
  public $Title;
  public $Place;
  
  public $StartDate;
  public $EndDate;
  public $OneDayDate;
  public $StartTimestamp;
  public $EndTimestamp;
  
  public $Url;
  public $Info;
  public $FullInfo;
  
  public $Options = array();
  
  public function rules()
  {
    return array(
      array('ContactName, ContactPhone, ContactEmail, Title, Place, StartDate, EndDate, Info', 'required'),
      array('Url, Info, FullInfo, Options, OneDayDate', 'safe'),
      array('ContactEmail', 'email'),
      array('StartDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'StartTimestamp'),
      array('EndDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'EndTimestamp'),
    );
  }
  
  
  public function attributeLabels()
  {
    return array(
      'ContactName' => \Yii::t('app', 'ФИО'),
      'ContactPhone' => \Yii::t('app', 'Контактный телефон'),
      'ContactEmail' => \Yii::t('app', 'Контактный email'),
      'Title' => \Yii::t('app', 'Название мероприятия'),
      'Place' => \Yii::t('app', 'Место проведения'),
      'Date' => \Yii::t('app', 'Дата проведения'),
      'Url' => \Yii::t('app', 'Сайт мероприятия'),
      'Info' => \Yii::t('app', 'Краткое описание'),
      'FullInfo' => \Yii::t('app', 'Подробное описание'),
      'Options' => \Yii::t('app', 'Выберите необходимые вашему мероприятию опции'),
      'StartDate' => \Yii::t('app', 'Дата начала'),
      'EndDate' => \Yii::t('app', 'Дата окончания'),
      'OneDayDate' => \Yii::t('app', 'один день')
    );
  }
  
  public function getOptionsData()
  {
    return array(
      1 => \Yii::t('app', 'размещение информации в календаре'),
      2 => \Yii::t('app', 'регистрация участников'),
      3 => \Yii::t('app', 'прием оплаты'),
      5 => \Yii::t('app', 'реклама и маркетинг')
    );
  }
  
  public function getOptionValue($id)
  {
    $optionsData = $this->getOptionsData();
    return $optionsData[$id];
  }
}
