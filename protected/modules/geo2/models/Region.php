<?php
namespace geo2\models;

/**
 * @property int $Id
 * @property int $ExtId
 * @property int $CountryId
 * @property string $Name
 * @property int $Priority
 * @property bool $CitiesParsed
 * @property bool $Error
 * @property bool $Start
 *
 * @property Country $Country
 *
 * @method Region find($condition='',$params=array())
 * @method Region findByPk($pk,$condition='',$params=array())
 * @method Region[] findAll($condition='',$params=array())
 */
class Region extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Region
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Geo2Region';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Country' => [self::BELONGS_TO, 'geo2\models\Country', 'CountryId'],
        ];
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
}