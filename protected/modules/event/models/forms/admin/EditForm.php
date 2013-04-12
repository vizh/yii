<?php
namespace event\models\forms\admin;

class EditForm extends \CFormModel
{
  public $Title;
  public $IdName;
  public $Info;
  public $FullInfo;
  public $Visible;
  public $TypeId;
  public $ShowOnMain;
  public $Approved = 0;
  
  public $StartYear;
  public $StartMonth;
  public $StartDay;
  
  public $Logo;

  public $SiteUrl;
  
  public $EndYear;
  public $EndMonth;
  public $EndDay;
  
  public $Widgets;
  
  public $ProfInterest;
  
  public $Address;

  public function rules()
  {
    return array(
      array('Title, IdName, Info, StartYear, StartMonth, StartDay, EndYear, EndMonth, EndDay', 'required'),
      array('Info', 'filter', 'filter' => array(new \application\components\utility\Texts(), 'filterPurify')),
      array('Title, IdName, Info, FullInfo, Visible, TypeId, ShowOnMain, Approved, Widgets, ProfInterest', 'safe'),
      array('Logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
      array('SiteUrl', 'url', 'allowEmpty' => true)
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Title' => \Yii::t('app', 'Название'),
      'Info' => \Yii::t('app', 'Краткая информация'),
      'FullInfo' => \Yii::t('app', 'Информация'),
      'Date' => \Yii::t('app', 'Дата проведения'),
      'Type' => \Yii::t('app', 'Тип'),
      'Visible' => \Yii::t('app', 'Публиковать'),
      'ShowOnMain' => \Yii::t('app', 'Публиковать на главной'),
      'Widgets' => \Yii::t('app', 'Виджеты'),
      'ProfInterest' => \Yii::t('app', 'Профессиональные интересы'),
      'Approved' => \Yii::t('app', 'Статус'),
      'Logo' => \Yii::t('app', 'Лого'),
      'SiteUrl' => \Yii::t('app', 'URl сайта'),
      'Address' => \Yii::t('app', 'Адрес')
    );
  }
  
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
}
