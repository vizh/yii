<?php
namespace user\models\search\admin;

use application\components\form\SearchFormModel;
use user\models\User;

class Contacts extends SearchFormModel
{
    public $Query;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['Query', 'safe']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'RunetId' => 'RUNET&mdash;ID',
            'FirstName' => 'Имя',
            'LastName' => 'Фамилия',
            'FatherName' => 'Отчество',
            'Phone' => 'Номер телефона',
            'Company' => 'Компания',
            'Position' => 'Должность',
            'IriEcoSystem' => 'Экосистема ИРИ',
            'IriRole' => 'Статус ИРИ',
            'Birthday' => 'Дата рождения'
        ];
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $model = User::model();
        if ($this->validate()) {
            if (!empty($this->Query)) {
                $model->bySearch($this->Query, null, true, false);
            }
        }
        return new \CActiveDataProvider($model);
    }
}