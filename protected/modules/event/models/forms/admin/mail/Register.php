<?php
namespace event\models\forms\admin\mail;


class Register extends \CFormModel
{
  public $Subject;
  public $Body;

  public function rules()
  {
    return [
      ['Subject,Body', 'required'],
      ['Body', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Subject' => \Yii::t('app', 'Тема письма'),
      'Body' => \Yii::t('app', 'Тело письма')
    ];
  }


} 