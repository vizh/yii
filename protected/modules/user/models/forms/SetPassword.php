<?php
namespace user\models\forms;

class SetPassword extends \CFormModel
{
    const SCENARIO_SKIP_VALIDATION = 'skip_validation';

    public $Password;
    public $Skip;

    public function rules()
    {
        return [
            ['Password', 'required', 'except' => self::SCENARIO_SKIP_VALIDATION],
            ['Password', 'length', 'min' => \Yii::app()->params['UserPasswordMinLenght'], 'except' => self::SCENARIO_SKIP_VALIDATION],
            ['Skip', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return ['Password' => \Yii::t('app', 'Новый пароль')];
    }


} 