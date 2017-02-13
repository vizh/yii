<?php
namespace contact\models\forms;

use application\components\form\CreateUpdateForm;
use contact\models\Address as AddressModel;
use geo\models\City;

class Address extends CreateUpdateForm
{
    const ScenarioRequired = 'required';

    public $CountryId;
    public $RegionId;
    public $CityId;

    public $CityLabel;

    public $Street;
    public $House;
    public $Building;
    public $Wing;
    public $Place;
    public $Apartment;
    public $GeoPoint;

    public function rules()
    {
        return [
            ['Street,House,Building,Wing,Place,Apartment,GeoPoint', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Street,House,Building,Wing,Place,Apartment,GeoPoint', 'safe'],
            ['CountryId', 'exist', 'className' => '\geo\models\Country', 'attributeName' => 'Id', 'allowEmpty' => true],
            ['CityId', 'exist', 'className' => '\geo\models\City', 'attributeName' => 'Id', 'allowEmpty' => true],
            ['RegionId', 'exist', 'className' => '\geo\models\Region', 'attributeName' => 'Id', 'allowEmpty' => true],
            ['CityLabel', 'validateCityLabel'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        parent::setAttributes($values, $safeOnly);
        $this->setAttributesByCityLabel();
    }

    /**
     * Заполнить атрибуты географического положения, если задано только название города, и такой город есть в базе
     */
    private function setAttributesByCityLabel()
    {
        if (empty($this->CityLabel) || !$this->isGeoEmpty()) {
            return;
        }
        $city = City::model()->byName($this->CityLabel)->ordered()->find();
        if (!empty($city)) {
            $this->CityId = $city->Id;
            $this->RegionId = $city->RegionId;
            $this->CountryId = $city->CountryId;
        }
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function validateCityLabel($attribute)
    {
        $value = $this->$attribute;
        if ((!empty($value) || $this->getScenario() == self::ScenarioRequired) && $this->isGeoEmpty()) {
            $this->addError('CityLabel', \Yii::t('app', 'Выберите город из выпадающего списка. Если вашего города нет, укажите свой регион.'));
        }
        if (empty($value)) {
            $this->CityId = $this->RegionId = $this->CountryId = null;
        }
        return $value;
    }

    public function attributeLabels()
    {
        return array(
            'CityLabel' => \Yii::t('app', 'Город'),
            'House' => \Yii::t('app', 'Дом'),
            'Building' => \Yii::t('app', 'Строение'),
            'Wing' => \Yii::t('app', 'Корпус'),
            'Street' => \Yii::t('app', 'Улица'),
            'Place' => \Yii::t('app', 'Место'),
            'Apartment' => \Yii::t('app', 'Офис'),
            'Latitude' => \Yii::t('app', 'Широта'),
            'Longitude' => \Yii::t('app', 'Долгота')
        );
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new AddressModel();
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
     * Возвораешь true, если не заданы поля географического положения
     * @return bool
     */
    private function isGeoEmpty()
    {
        return empty($this->CityId) && empty($this->RegionId) && empty($this->CountryId);
    }

    /**
     * @deprecated
     * @return bool
     */
    public function getIsEmpty()
    {
        $isEmpty = true;
        foreach (array_keys($this->attributes) as $attr) {
            if (!empty($this->$attr)) {
                $isEmpty = false;
                break;
            }
        }
        return $isEmpty;
    }
}
