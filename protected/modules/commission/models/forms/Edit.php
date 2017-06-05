<?php
namespace commission\models\forms;

class Edit extends \CFormModel
{
    public $Title;
    public $Description;
    public $Url;

    public function rules()
    {
        return [
            ['Title, Description, Url', 'required'],
            ['Url', 'url']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название'),
            'Description' => \Yii::t('app', 'Описание'),
            'Url' => \Yii::t('app', 'Ссылка на страницу комиссии')
        ];
    }
}
