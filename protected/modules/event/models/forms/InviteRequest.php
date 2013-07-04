<?php
namespace event\models\forms;

class InviteRequest extends \CFormModel
{
  public $Phone;
  public $Company;
  public $Position;
  public $Info;
  
  public function attributeLabels()
  {
    return [
      'Phone' => \Yii::t('app', 'Ваш телефон'),
      'Company' => \Yii::t('app', 'Ваше место работы'),
      'Position' => \Yii::t('app', 'Ваша должность'),
      'Info' => \Yii::t('app', 'C чем связан ваш интерес к конференции')
    ];
  }
  
  public function rules()
  {
    return array(
      array('Phone,Company,Position,Info', 'required')
    );
  }
}
