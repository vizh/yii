<?php
namespace user\models\forms\edit;
class Employments extends \user\models\forms\edit\Base
{
  public $Employments = array();
  
  public function rules()
  {
    return array(
      array('Employments', 'filter', 'filter' => array($this, 'filterArrayPurify')),
      array('Employments', 'safe')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Company' => \Yii::t('app', 'Компания'),
      'Position' => \Yii::t('app', 'Должность'),
      'Date' => \Yii::t('app', 'Период работы'),
      'Primary' => \Yii::t('app', 'Основное место работы')
    );
  }
  
  public function getMonthOptions()
  {
    $html = '<option value=""></option>';
    foreach (\Yii::app()->locale->getMonthNames('wide', true) as $month => $title) 
    {
      $html .= '<option value="'.$month.'">'.$title.'</option>';
    }
    return $html;
  }
  
  public function getYearOptions()
  {
    $html = '<option value=""></option>';
    for($y = date('Y'); $y >= 1980; $y--)
    {
      $html .= '<option value="'.$y.'"'.($y == $maxYear ? 'selected' : '').'>'.$y.'</option>';
    }
    return $html;
  }
}
