<?php
namespace partner\models\forms\admin;

class Account extends \CFormModel
{
    public $EventId;
    public $EventTitle;
    public $Role = 'Partner';
    public $Login;

    public function rules()
    {
        return [
            ['EventId', 'required'],
            ['EventId', 'exist', 'attributeName' => 'Id', 'className' => '\event\models\Event'],
            ['Role', 'filter', 'filter' => [$this, 'filterRole']],
            ['Login', 'safe'],
            ['EventTitle', 'safe']
        ];
    }

    public function filterRole($value)
    {
        if (!array_key_exists($value, $this->getRoles())) {
            $this->addError('Role', \Yii::t('app', 'Некорректно задана роль.'));
        }
        return $value;
    }

    public function attributeLabels()
    {
        return [
            'EventTitle' => \Yii::t('app', 'Название мероприятия'),
            'EventId'    => \Yii::t('app', 'Id меропрития'),
            'Role'        => \Yii::t('app', 'Роль'),
            'Login'    => \Yii::t('app', 'Логин')
        ];
    }

    public function getRoles()
    {
        return [
            'Partner' => 'Партнер',
            'PartnerVerified' => 'Одобренный партнер',
            'Admin' => 'Администратор',
        ];
    }
}