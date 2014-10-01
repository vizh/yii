<?php
namespace geo\models;

/**
 * @property int $Id
 * @property int $CountryId
 * @property int $RegionId
 * @property int $Name
 *
 * @property Country $Country
 * @property Region $Region
 *
 * Вспомогательные описания методов методы
 * @method \geo\models\City find($condition='',$params=array())
 * @method \geo\models\City findByPk($pk,$condition='',$params=array())
 * @method \geo\models\City[] findAll($condition='',$params=array())
 */
class City extends \application\models\translation\ActiveRecord
{
    /**
     * @param string $className
     *
     * @return City
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static $TableName = 'GeoCity';

    public function tableName()
    {
        return self::$TableName;
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Country' => array(self::BELONGS_TO, 'geo\models\Country', 'CountryId'),
            'Region' => array(self::BELONGS_TO, 'geo\models\Region', 'RegionId')
        );
    }

    /**
     * @static
     * @param int $id
     * @return City|null
     */
    public static function GetById($id)
    {
        $city = City::model();
        return $city->findByPk($id);
    }

    /**
     * @static
     * @param int $regionId
     * @return City[]
     */
    public static function GetCityByRegion($regionId)
    {
        $city = City::model();
        $criteria = new \CDbCriteria();
        $criteria->condition = 't.RegionId = :RegionId';
        $criteria->order = 'Priority DESC, Name';
        $criteria->params = array(':RegionId' => $regionId);
        return $city->findAll($criteria);
    }

    /**
     * @return Country
     */
    public function GetCountry()
    {
        if (isset($this->Country))
        {
            return $this->Country;
        }
        else
        {
            return null;
        }
    }

    /**
     * @desc НАЗВАНИЕ ГОРОДА
     */
    public function GetName()
    {
        return $this->Name;
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return array('Name');
    }

    /**
     * @param int $countryId
     * @param bool $useAnd
     * @return $this
     */
    public function byCountryId($countryId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CountryId" = :CountryId';
        $criteria->params = ['CountryId' => $countryId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $regionId
     * @param bool $useAnd
     * @return $this
     */
    public function byRegionId($regionId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."RegionId" = :RegionId';
        $criteria->params = ['RegionId' => $regionId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}