<?php
namespace contact\models\forms;

use application\components\form\CreateUpdateForm;
use contact\models\Phone as PhoneModel;
use contact\models\PhoneType;

class Phone extends CreateUpdateForm
{
    const ScenarioOneField = 'OneField';
    const ScenarioOneFieldRequired = 'OneFieldRequired';

    public $OriginalPhone;
    public $CountryCode;
    public $CityCode;
    public $Phone;
    public $Type = PhoneType::Mobile;
    public $Id;
    public $Delete = 0;

    /** @var PhoneModel|null */
    protected $model;

    /**
     * @inheritDoc
     */
    public function __construct($scenario = '', PhoneModel $model = null)
    {
        parent::__construct($model);
        $this->setScenario($scenario);
    }

    /**
     * @inheritDoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $this->OriginalPhone = $this->model->getWithoutFormatting();
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            ['CountryCode, CityCode, Phone, Type', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['CountryCode, Phone', 'required', 'except' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
            ['CityCode, Type', 'safe'],
            ['Id, Delete', 'numerical', 'allowEmpty' => true],
            ['CountryCode, CityCode, Phone', 'numerical', 'except' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
            ['OriginalPhone', 'safe', 'on' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
            ['Phone', 'filter', 'filter' => [$this, 'filterPhone'], 'on' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]]
        ];
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function filterPhone($value)
    {
        $valid = true;
        if ($this->getScenario() == self::ScenarioOneField) {
            if ((!empty($this->OriginalPhone) && $this->getIsEmpty()) || (!empty($this->CountryCode) && empty($this->Phone)) || (empty($this->CountryCode) && !empty($this->Phone))) {
                $valid = false;
            }
        } elseif ($this->getScenario() == self::ScenarioOneFieldRequired) {
            if (empty($this->CountryCode) || empty($this->Phone)) {
                $valid = false;
            }
        }
        if (!$valid) {
            $this->addError('Phone', \Yii::t('app', 'Необходимо заполнить поле Номер телефона.'));
        }
        return $value;
    }

    /**
     * @return bool
     */
    protected function beforeValidate()
    {
        if ($this->getScenario() == self::ScenarioOneField || $this->getScenario() == self::ScenarioOneFieldRequired) {
            $attributes = $this->getAttributes();
            if (preg_match('/\+?(\d+)(\(\d+\))?([\d-]+)/', $attributes['OriginalPhone'], $matches) > 0) {
                $attributes['CountryCode'] = $matches[1];
                if (!empty($matches[2])) {
                    $attributes['CityCode'] = trim($matches[2], '()');
                }
                $attributes['Phone'] = str_replace('-', '', $matches[3]);
            }
            $this->setAttributes($attributes);
        }
        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'CountryCode' => \Yii::t('app', 'Код страны'),
            'CityCode' => \Yii::t('app', 'Код города'),
            'Phone' => \Yii::t('app', 'Телефон'),
            'Type' => \Yii::t('app', 'Тип телефона')
        ];
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new PhoneModel();
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
        $this->model->save();
        return $this->model;
    }

    /**
     * @deprecated
     * @return bool
     */
    public function getIsEmpty()
    {
        return empty($this->CountryCode) && empty($this->Phone);
    }
}
