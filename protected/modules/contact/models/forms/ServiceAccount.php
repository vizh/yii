<?php
namespace contact\models\forms;

class ServiceAccount extends \CFormModel
{
    public $TypeId;
    public $Account;
    public $Delete = 0;
    public $Id;

    public function rules()
    {
        return [
            ['Account', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
            ['Account', 'required'],
            ['TypeId', 'exist', 'className' => '\contact\models\ServiceType', 'attributeName' => 'Id'],
            ['Id,Delete', 'numerical', 'allowEmpty' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'TypeId' => \Yii::t('app', 'Сервис'),
            'Account' => \Yii::t('app', 'Аккаунт')
        ];
    }
}
