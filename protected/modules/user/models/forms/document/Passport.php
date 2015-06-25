<?php
namespace user\models\forms\document;

class Passport extends BaseDocument
{
    public $Series;
    public $Number;
    public $PlaceIssue;
    public $DateIssue;
    public $Authority;
    public $LastName;
    public $FirstName;
    public $FatherName;
    public $Birthday;
    public $PlaceBirth;
    public $RegisteredAddress;
    public $ResidenceAddress;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Series' => \Yii::t('app', 'Серия'),
            'Number' => \Yii::t('app', 'Номер'),
            'PlaceIssue' => \Yii::t('app', 'Кем выдан'),
            'DateIssue' => \Yii::t('app', 'Дата выдачи'),
            'Authority' => \Yii::t('app', 'Код подразделения'),
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FirstName' => \Yii::t('app', 'Имя'),
            'FatherName' => \Yii::t('app', 'Отчество'),
            'Birthday' => \Yii::t('app', 'Дата рождения'),
            'PlaceBirth' => \Yii::t('app', 'Место рождения'),
            'RegisteredAddress' => \Yii::t('app', 'Адрес регистрации'),
            'ResidenceAddress' => \Yii::t('app', 'Адрес проживания'),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Series,Number,PlaceIssue,DateIssue,Authority,LastName,FirstName,FatherName,Birthday,PlaceBirth,RegisteredAddress,ResidenceAddress', 'filter', 'filter' => 'application\components\utility\Texts::clear'],
            ['Series,Number,PlaceIssue,DateIssue,Authority,LastName,FirstName,Birthday,PlaceBirth,RegisteredAddress,ResidenceAddress', 'required'],
            ['DateIssue,Birthday', 'date', 'format' => 'dd.MM.yyyy']
        ];
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            $this->FirstName = $this->user->FirstName;
            $this->LastName = $this->user->LastName;
            $this->FatherName = $this->user->FatherName;

            if (!empty($this->user->Birthday)) {
                $this->Birthday = \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $this->user->Birthday);
            }
        }
        return parent::loadData();
    }
} 