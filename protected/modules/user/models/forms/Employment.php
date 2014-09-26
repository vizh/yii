<?php
namespace user\models\forms;

class Employment extends \CFormModel
{
    public $Id = null;
    public $Company;
    public $Position;
    public $StartMonth;
    public $StartYear;
    public $EndMonth;
    public $EndYear;
    public $Primary = 0;
    public $Delete = 0;

    public function rules()
    {
        return array(
            array('Company,Position,Primary,Delete', 'filter', 'filter' => '\application\components\utility\Texts::clear'),
            array('Company', 'required'),
            array('Position', 'safe'),
            array('Id,StartMonth,StartYear,EndMonth,EndYear,Primary,Delete', 'numerical', 'allowEmpty' => true)
        );
    }

    protected function beforeValidate()
    {
        if (!empty($this->StartMonth) && empty($this->StartYear))
        {
            $this->addError('StartYear', \Yii::t('app', 'Необходимо заполнить поле Год начала работы'));
        }
        if (!empty($this->EndMonth) && empty($this->EndYear))
        {
            $this->addError('EndYear', \Yii::t('app', 'Необходимо заполнить поле Год окончания работы'));
        }
        return true;
    }

    public function attributeLabels()
    {
        return array(
            'Company' => \Yii::t('app', 'Компания'),
            'Position' => \Yii::t('app', 'Должность'),
            'StartMonth' => \Yii::t('app', 'Месяц начала работы'),
            'StartYear' => \Yii::t('app', 'Год начала работы'),
            'EndMonth' => \Yii::t('app', 'Месяц окончания работы'),
            'EndYear' => \Yii::t('app', 'Год окончания работы'),
            'Primary' => \Yii::t('app', 'Основное место работы'),
            'Delete' => \Yii::t('app', 'Удалить')
        );
    }
}
