<?php
namespace catalog\models\company\forms;

class Edit extends \CFormModel
{
    public $Title;
    public $CompanyId;
    public $Url;

    public $Logos;

    public function rules()
    {
        return [
            ['Title', 'required'],
            ['CompanyId', 'numerical', 'integerOnly' => true],
            ['Url', 'url', 'allowEmpty' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название'),
            'CompanyId' => \Yii::t('app', 'ID компании RUNET-ID'),
            'Url' => \Yii::t('app', 'Url сайта')
        ];
    }
}
