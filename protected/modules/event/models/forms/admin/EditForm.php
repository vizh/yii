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
  
  public $EndYear;
  public $EndMonth;
  public $EndDay;
  
  public $Widgets;
  
  public $ProfInterest;


  public function rules()
  {
    return array(
      array('Title, IdName, Info, FullInfo, Visible, TypeId, ShowOnMain, Approved, StartYear, StartMonth, StartDay, EndYear, EndMonth, EndDay, Widgets, ProfInterest', 'safe')
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
      'ProfInterest' => \Yii::t('app', 'Профессиональные интересы')
    );
  }
}
