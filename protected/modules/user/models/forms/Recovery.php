<?php
namespace user\models\forms;
class Recovery extends \CFormModel
{
  public $Email;
  
  public function rules()
  {
    return array(
      array('Email', 'required'),
      array('Email', 'email')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Email' => \Yii::t('app', 'Электронная почта')
    );
  }
}
