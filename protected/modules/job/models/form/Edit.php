<?php
namespace job\models\form;

class Edit extends \CFormModel
{
  public $Title;
  public $Text;
  public $SalaryFrom;
  public $SalaryTo;
  public $Visible;
  public $Url;
  public $Company;
  public $Category;
  public $Position;
  
  public $JobUp;
  public $JobUpStartTime;
  public $JobUpEndTime;
  
  public function attributeLabels()
  {
    return array(
      'Title' => \Yii::t('app', 'Заголовок'),
      'Text' => \Yii::t('app', 'Описание'),
      'SalaryFrom' => \Yii::t('app', 'Зарплата ОТ'),
      'SalaryTo' => \Yii::t('app', 'Зарплата ДО'),
      'Url' => \Yii::t('app', 'Ссылка'),
      'Company' => \Yii::t('app', 'Компания'),
      'Category' => \Yii::t('app', 'Категория'),
      'Position' => \Yii::t('app', 'Специальность'),
      'Visible' => \Yii::t('app', 'Опубликовано'),
      'JobUp' => \Yii::t('app', 'Выделить'),
      'JobUpStartTime' => \Yii::t('app', 'Выделять C'),
      'JobUpEndTime' => \Yii::t('app', 'Выделять ДО')
    );
  }
  
  public function rules()
  {
    return array(
      array('Title, Text, Url, Company, Category, Position, Visible', 'required'),
      array('SalaryFrom, SalaryTo', 'numerical', 'allowEmpty' => true),
      array('JobUp', 'safe'),
      array('JobUpStartTime, JobUpEndTime', 'date', 'format' => 'dd.MM.yyyy HH:mm', 'allowEmpty' => true),
      array('Url', 'url')
    );
  }
  
  public function getCategoryList()
  {
    return \CHtml::listData(\job\models\Category::model()->findAll(), 'Id', 'Title');
  }
}
