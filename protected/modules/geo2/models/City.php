<?php
namespace geo2\models;

use application\components\utility\Texts;

/**
 * @property int $Id
 * @property int $ExtId
 * @property int $CountryId
 * @property int $RegionId
 * @property int $Name
 * @property string $Area
 * @property int $Priority
 * @property bool $Parsed
 *
 * @property Country $Country
 * @property Region $Region
 *
 * Вспомогательные описания методов методы
 * @method City find($condition='',$params=array())
 * @method City findByPk($pk,$condition='',$params=array())
 * @method City[] findAll($condition='',$params=array())
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

    public function tableName()
    {
        return 'Geo2City';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Country' => [self::BELONGS_TO, 'geo2\models\Country', 'CountryId'],
            'Region' => [self::BELONGS_TO, 'geo2\models\Region', 'RegionId']
        ];
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Name'];
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

    /**
     * @param string $name
     * @param bool $useAnd
     * @return $this
     */
    public function byName($name, $useAnd = true)
    {
        $name = Texts::prepareStringForTsvector($name);
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."SearchName" @@ to_tsquery(:Name)';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function getAbsoluteName()
    {
        $result = $this->Country->Name.', ';
        if ($this->RegionId != null) {
            $result .= $this->Region->Name.', ';
        }
        return $result . $this->Name;
    }
}