<?php
namespace user\models\forms;

class Email extends \CFormModel
{
    const SCENARIO_VISIBLE_USER = 'VISIBLE_USER';

  public $Email;

  public function rules()
  {
    return [
      ['Email', 'email', 'allowEmpty' => false],
      ['Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false, 'message' => \Yii::t('app', 'Пользователь с таким Email уже существует.'), 'on' => self::SCENARIO_VISIBLE_USER]
    ];
  }
} 