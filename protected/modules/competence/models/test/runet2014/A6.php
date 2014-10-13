<?php
namespace competence\models\test\runet2014;

use competence\models\Result;
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
        $user = \Yii::app()->user->getCurrentUser();
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
            ['main_email', 'required'],
            ['main_email,work_email,additional_email', 'email'],
            ['mobile_phone, work_phone', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'work_phone' => 'Рабочий телефон',
            'mobile_phone' => 'Мобильный телефон',
            'main_email' => 'Основной  адрес электронной почты',
            'work_email' => 'Рабочий адрес электронной почты',
            'additional_email' => 'Дополнительный адрес электронной почты'
        ];
    }

    public function getInternalExportValueTitles()
    {
        return ['Рабочий телефон', 'Мобильный телефон', 'Основной  адрес электронной почты', 'Рабочий адрес электронной почты', 'Дополнительный адрес электронной почты'];
    }

    public function getInternalExportData(Result $result)
    {
        $data = $result->getQuestionResult($this->question);
        return !empty($data) ? [$data['work_phone'], $data['mobile_phone'], $data['main_email'], $data['work_email'], $data['additional_email'],] : ['', '', '', '', ''];
    }
}
