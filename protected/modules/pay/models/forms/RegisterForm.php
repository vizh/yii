<?php
namespace pay\models\forms;

class RegisterForm extends \CFormModel
{
    public $FirstName;
    public $LastName;
    public $SecondName;
    public $Company;
    public $Position;
    public $Email;
    public $Phone;
    public $Password;

    public function rules()
    {
        return [
            ['FirstName, LastName, Email, Password, Company', 'required'],
            ['Email', 'email'],
            ['Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email'],
            ['FirstName, LastName, SecondName, Company, Position, Email, Phone', 'filter', 'filter' => [$this, 'filterPurify']]
        ];
    }

    public function filterPurify($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => []
        ];
        $value = $purifier->purify($value);
        return $value;
    }

    public function attributeLabels()
    {
        return [
            'FirstName' => \Yii::t('tc2012', 'Имя'),
            'LastName' => \Yii::t('tc2012', 'Фамилия'),
            'SecondName' => \Yii::t('tc2012', 'Отчество'),
            'Company' => \Yii::t('tc2012', 'Компания'),
            'Position' => \Yii::t('tc2012', 'Должность'),
            'Email' => 'Email',
            'Phone' => \Yii::t('tc2012', 'Телефон'),
            'Password' => \Yii::t('tc2012', 'Пароль')
        ];
    }
}
