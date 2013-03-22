<?php
namespace user\models\forms;
class Recovery extends \CFormModel
{
  public $Email;
  public $Code;
  public $ShowCode = false;
  
  public function rules()
  {
    return array(
      array('Email', 'required'),
      array('Email', 'email'),
      array('Code', 'safe')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Email' => \Yii::t('app', 'Электронная почта')
    );
  }
}
