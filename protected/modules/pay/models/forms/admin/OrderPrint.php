<?php
namespace pay\models\forms\admin;

class OrderPrint extends \CFormModel
{
  public $EventLabel;
  public $EventId;
  public $DateFrom;

  public function rules()
  {
    return [
      ['EventLabel,EventId', 'required'],
      ['EventId', 'exist', 'attributeName' => 'Id', 'className' => '\event\models\Event'],
      ['DateFrom', 'date', 'format' => 'dd.MM.yyyy', 'allowEmpty' => true]
    ];
  }

  public function attributeLabels()
  {
    return [
      'EventId' => \Yii::t('app', 'ID мероприятия'),
      'DateFrom' => \Yii::t('app', 'Начальная дата'),
      'EventLabel' => \Yii::t('app', 'Название мероприятия')
    ];
  }


} 