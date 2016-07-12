<?php

namespace user\models\forms\edit;

use user\models\forms\edit\Base;
use user\models\Gender;

/**
 * Содержит основные поля пользователя из модели User
 */
class Main extends Base
{
    public $LastName;

    public $FirstName;

    public $FatherName;

    public $Birthday;

    public $Gender = Gender::None;

    public function rules()
    {
        return [
            ['LastName, FirstName, FatherName, Birthday, Gender', 'filter',
                'filter' => [$this, 'filterPurify']
            ],
            ['LastName, FirstName', 'required'],
            ['FatherName, Gender', 'safe'],
            ['Birthday', 'date', 'format' => 'dd.MM.yyyy'],
            ['LastName, FirstName, FatherName', 'length', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'LastName' => \Yii::t('app', 'Фамилия').' <span class="required">*</span>',
            'FatherName' => \Yii::t('app', 'Отчество'),
            'FirstName' => \Yii::t('app', 'Имя').' <span class="required">*</span>',
            'Birthday' => \Yii::t('app', 'Дата рождения'),
        ];
    }

    public function getGenderList()
    {
        return [
            Gender::Male => \Yii::t('app', 'Мужчина'),
            Gender::Female => \Yii::t('app', 'Женщина'),
            Gender::None => \Yii::t('app', 'Не указывать'),
        ];
    }
}
