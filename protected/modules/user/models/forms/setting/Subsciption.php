<?php
namespace user\models\forms\setting;

class Subsciption extends \CFormModel
{
  public $Subscribe = 1;
  
  public function rules()
  {
    return array(
      array('Subscribe', 'numerical')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Subscribe'  => \Yii::t('app', 'Получать рассылки системы RUNET&ndash;ID'),
    );
  }
}
