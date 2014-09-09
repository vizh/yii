<?php
namespace competence\models\test\runet2014;

use user\models\User;

class A6 extends \competence\models\form\Base
{
    public $work_phone;
    public $mobile_phone;
    public $work_email;
    public $main_email;
    public $additional_email;

    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        /** @var User $user */
        $user = \Yii::app()->getUser()->getCurrentUser();
        if (empty($this->main_email)) {
            $this->main_email = $user->Email;
        }

        if (empty($this->mobile_phone) && !empty($user->PrimaryPhone)) {
            $this->mobile_phone = $user->PrimaryPhone;
        }
    }

    protected function getFormData()
    {
        return [
            'work_phone' => $this->work_phone,
            'mobile_phone' => $this->mobile_phone,
            'work_email' => $this->work_email,
            'main_email' => $this->main_email,
            'additional_email' => $this->additional_email
        ];
    }

    public function rules()
    {
        return [
            ['mobile_phone, main_email', 'required'],
            ['main_email,work_email,additional_email', 'email'],
            ['work_phone', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'work_phone'       => 'Рабочий телефон',
            'mobile_phone'     => 'Мобильный телефон',
            'main_email'       => 'Основной  адрес электронной почты',
            'work_email'       => 'Рабочий адрес электронной почты',
            'additional_email' => 'Дополнительный адрес электронной почты'
        ];
    }
}
