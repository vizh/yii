<?php
namespace user\models\forms\setting;

class Password extends \CFormModel
{
    public $OldPassword;

    public $NewPassword1;
    public $NewPassword2;

    public function rules()
    {
        return [
            ['OldPassword, NewPassword1, NewPassword2', 'required'],
            ['NewPassword1', 'length', 'min' => \Yii::app()->params['UserPasswordMinLenght']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'OldPassword' => \Yii::t('app', 'Текущий пароль').'<span class="required">*</span>',
            'NewPassword1' => \Yii::t('app', 'Новый пароль').' <span class="required">*</span>',
            'NewPassword2' => \Yii::t('app', 'Новый пароль, ещё разок').' <span class="required">*</span>'
        ];
    }
}
