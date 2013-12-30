<?php
namespace event\models\forms;
class Create extends \CFormModel
{
  public $ContactName;
  public $ContactPhone;
  public $ContactEmail;
  
  public $Title;
  public $Place;

  public $LogoSource;

  public $StartDate;
  public $EndDate;
  public $OneDayDate;
  public $StartTimestamp;
  public $EndTimestamp;

  public $Url;
  public $Info;
  public $FullInfo;

  public $Options = array();
  
  public $PlannedParticipants;

  public function rules()
  {
    return [
      ['ContactName, ContactPhone, ContactEmail, Title, Place, StartDate, EndDate, Info', 'required'],
      ['ContactEmail', 'filter', 'filter' => 'trim'],
      ['Url, Info, FullInfo, Options, OneDayDate, LogoSource', 'safe'],
      ['LogoSource', 'file', 'allowEmpty' => false],
      ['ContactEmail', 'email'],
      ['StartDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'StartTimestamp'],
      ['EndDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'EndTimestamp'],
      ['PlannedParticipants', 'filter', 'filter' => [$this, 'filterPlannedParticipants']]
    ];
  }

  protected function beforeValidate()
  {
    $attributes = $this->attributes;
    if ($attributes['OneDayDate'] == 1)
    {
      $attributes['EndDate'] = $attributes['StartDate'];
    }
    $this->setAttributes($attributes);
    return parent::beforeValidate();
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
      'LogoSource' => \Yii::t('app', 'Логотип'),
      'FullInfo' => \Yii::t('app', 'Подробное описание'),
      'Options' => \Yii::t('app', 'Выберите необходимые вашему мероприятию опции'),
      'StartDate' => \Yii::t('app', 'Дата начала'),
      'EndDate' => \Yii::t('app', 'Дата окончания'),
      'OneDayDate' => \Yii::t('app', 'один день'),
      'PlannedParticipants' => \Yii::t('app', 'Планируемое кол-во участников')
    );
  }
  
  public function getOptionsData()
  {
    return array(
      1 => \Yii::t('app', 'размещение информации в календаре'),
      2 => \Yii::t('app', 'регистрация участников'),
      3 => \Yii::t('app', 'прием оплаты'),
      5 => \Yii::t('app', 'реклама и маркетинг'),
      6 => \Yii::t('app', 'оффлайн регистрация')
    );
  }
  
  public function getOptionValue($id)
  {
    $optionsData = $this->getOptionsData();
    return $optionsData[$id];
  }
  
  function filterPlannedParticipants($value)
  {
    if (in_array(6, $this->Options) && empty($this->PlannedParticipants))
    {
      $this->addError('PlannedParticipants', \Yii::t('app', 'Необходимо заполнить поле Планируемое кол-во участников'));
    }
    return $value;
  }
}
