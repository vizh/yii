<?php
namespace contact\models\forms;

class Email extends \CFormModel
{
    public $Email;
    public $Title;
    public $Id;
    public $Delete = 0;

    public function rules()
    {
        return [
            ['Title', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
            ['Email', 'required'],
            ['Email', 'email'],
            ['Id, Delete', 'numerical', 'allowEmpty' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Email' => \Yii::t('app', 'Адрес эл. почты'),
            'Title' => \Yii::t('app', 'Описание'),
        ];
    }
}
