<?php
namespace link\models\forms;

class Datetime extends \CFormModel
{
  public $Date;
  public $Time;

  public function rules()
	{
    return [
      ['Date,Time','required'],
      ['Date','date','format' => 'dd.MM.yyyy'],
      ['Time','date','format' => 'HH:mm']
    ];
  }

  public function attributeLabels()
  {
    return [
      'Date' => \Yii::t('app', 'Дата'),
      'Time' => \Yii::t('app', 'Время')
    ];
  }

  public function __toString()
  {
    return $this->Date.' '.$this->Time.':00';
  }
}