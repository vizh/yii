<?php
namespace raec\models\forms\admin;

use application\components\form\CreateUpdateForm;
use company\models\Company;
use raec\models\CompanyUser as CompanyUserModel;
use raec\models\CompanyUserStatus;

class CompanyUser extends CreateUpdateForm
{
    const DATE_FORMAT = 'dd.MM.yyyy';

    public $Id;

    public $UserId;

    public $StatusId;

    public $AllowVote;

    public $JoinTime;

    public $ExitTime;

    public $Delete = false;

    /** @var Company */
    private $company;

    /** @var CompanyUserModel */
    protected $model;

    /**
     * @param Company $company
     * @param CompanyUserModel $model
     */
    public function __construct(Company $company, CompanyUserModel $model = null)
    {
        parent::__construct($model);
        $this->company = $company;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['UserId,StatusId,AllowVote,JoinTime', 'required'],
            ['Id', 'exist', 'className' => '\raec\models\CompanyUser', 'attributeName' => 'Id'],
            ['UserId', 'exist', 'className' => '\user\models\User', 'attributeName' => 'Id'],
            ['StatusId', 'in', 'range' => array_keys($this->getStatusData())],
            ['AllowVote,Delete', 'boolean'],
            ['JoinTime,ExitTime', 'date', 'format' => self::DATE_FORMAT],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UserId' => \Yii::t('app', 'Пользователь'),
            'StatusId' => \Yii::t('app', 'Статус'),
            'AllowVote' => \Yii::t('app', 'Голосование'),
            'JoinTime' => \Yii::t('app', 'Дата начала'),
            'ExitTime' => \Yii::t('app', 'Дата выхода'),
            'Delete' => \Yii::t('app', 'Удалить')
        ];
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $formatter = \Yii::app()->getDateFormatter();
            $this->JoinTime = $formatter->format(self::DATE_FORMAT, $this->JoinTime);
            $this->ExitTime = !empty($this->ExitTime) ? $formatter->format(self::DATE_FORMAT, $this->JoinTime) : null;
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getStatusData()
    {
        $statuses = ['' => 'Статус'];
        $statuses = array_merge(
            $statuses,
            CompanyUserStatus::model()->orderBy('"t"."Title"')->findAll()
        );
        return \CHtml::listData($statuses, 'Id', 'Title');
    }

    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['Id'])) {
            $this->model = CompanyUserModel::model()->findByPk($values['Id']);
        }
        return parent::setAttributes($values, $safeOnly);
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new CompanyUserModel();
        $this->model->CompanyId = $this->company->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        $formatter = \Yii::app()->getDateFormatter();
        $this->model->JoinTime = $formatter->format('yyyy-MM-dd 00:00:00', $this->JoinTime);
        $this->model->ExitTime = !empty($this->ExitTime) ? $formatter->format('yyyy-MM-dd 23:59:59', $this->ExitTime) : null;

        if ($this->Delete) {
            $this->model->delete();
        } else {
            $this->model->save();
        }
        return $this->model;
    }

}