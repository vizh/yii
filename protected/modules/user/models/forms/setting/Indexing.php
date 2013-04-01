<?php
namespace user\models\forms\setting;

class Indexing extends \CFormModel
{
  public $Deny = 0;
  
  public function rules()
  {
    return array(
      array('Deny', 'required')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Deny' => \Yii::t('app', 'Я не хочу, чтобы мою страницу индексировали поисковые системы')
    );
  }
}
