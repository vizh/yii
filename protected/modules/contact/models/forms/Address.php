<?php
namespace contact\models\forms;

class Address extends \CFormModel
{
    public $CountryId;
    public $RegionId;
    public $CityId;

    public $CityLabel;

    public $Street;
    public $House;
    public $Building;
    public $Wing;
    public $Place;

    public function rules()
    {
        return array(
            array('Street,House,Building,Wing,Place', 'filter', 'filter' => array(new \application\components\utility\Texts(), 'filterPurify')),
            array('Street,House,Building,Wing,Place', 'safe'),
            array('CountryId', 'exist', 'className' => '\geo\models\Country', 'attributeName' => 'Id', 'allowEmpty' => true),
            array('CityId', 'exist', 'className' => '\geo\models\City', 'attributeName' => 'Id', 'allowEmpty' => true),
            array('RegionId', 'exist', 'className' => '\geo\models\Region', 'attributeName' => 'Id', 'allowEmpty' => true),
            array('CityLabel', 'filter', 'filter' => array($this, 'filterCityLabel')),
        );
    }

    public function filterCityLabel($value)
    {
        if (!empty($value) && (empty($this->CityId) && empty($this->CountryId)))
        {
            $this->addError('CityLabel', \Yii::t('app', 'Выберите город из выпадающего списка. Если вашего города нет, укажите свой регион.'));
        }

        if (empty($value))
        {
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
        );
    }

    public function getIsEmpty()
    {
        $isEmpty = true;
        foreach (array_keys($this->attributes) as $attr)
        {
            if (!empty($this->$attr))
            {
                $isEmpty = false;
                break;
            }
        }
        return $isEmpty;
    }
}
