<?php
namespace user\models\forms\document;

class ForeignPassport extends BaseDocument
{
    public $Type;
    public $CountryCode;
    public $Number;
    public $LastName;
    public $FirstName;
    public $Nationality;
    public $Birthday;
    public $PersonalNumber;
    public $PlaceBirth;
    public $DateIssue;
    public $Authority;
    public $DateExpire;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Type' => \Yii::t('app', 'Тип'),
            'CountryCode' => \Yii::t('app', 'Код государства'),
            'Number' => \Yii::t('app', 'Номер паспорта'),
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FirstName' => \Yii::t('app', 'Имя'),
            'Nationality' => \Yii::t('app', 'Гражданство'),
            'Birthday' => \Yii::t('app', 'Дата рождения'),
            'PersonalNumber' => \Yii::t('app', 'Личный код'),
            'PlaceBirth' => \Yii::t('app', 'Место рождения'),
            'DateIssue' => \Yii::t('app', 'Дата выдачи'),
            'Authority' => \Yii::t('app', 'Орган, выдавший документ'),
            'DateExpire' => \Yii::t('app', 'Дата окончания срока действия')
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Type,CountryCode,Number,LastName,FirstName,Nationality,Birthday,PersonalNumber,PlaceBirth,DateIssue,Authority,DateExpire', 'filter', 'filter' => 'application\components\utility\Texts::clear'],
            ['Type,CountryCode,Number,LastName,FirstName,Nationality,Birthday,PersonalNumber,PlaceBirth,DateIssue,Authority,DateExpire', 'required'],
            ['Birthday,DateIssue,DateExpire', 'date', 'format' => 'dd.MM.yyyy']
        ];
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            if (!empty($this->user->Birthday)) {
                $this->Birthday = \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $this->user->Birthday);
            }
        }
        return parent::loadData();
    }

}