<?php
namespace education\models;

use application\components\ActiveRecord;
use application\components\utility\Texts;
use geo\models\City;

/**
 * Class University
 * @package education\models
 *
 * @property int $Id
 * @property int $ExtId
 * @property int $CityId
 * @property string $Name
 * @property string $FullName
 * @property bool $Parsed
 * @property bool $Start
 *
 * @property City $City
 *
 * @method University find($condition='',$params=array())
 * @method University findByPk($pk,$condition='',$params=array())
 * @method University[] findAll($condition='',$params=array())
 */
class University extends ActiveRecord
{
    /**
     * @param string $className
     * @return University
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EducationUniversity';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'City' => [self::BELONGS_TO, City::className(), 'CityId']
        ];
    }

    /**
     * @param int $extId
     * @param bool $useAnd
     * @return $this
     */
    public function byExtId($extId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ExtId" = :ExtId';
        $criteria->params = ['ExtId' => $extId];
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
        $name = '%' . Texts::prepareStringForLike($name) . '%';
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" ILIKE :Name';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $cityId
     * @param bool $useAnd
     * @return $this
     */
    public function byCityId($cityId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CityId" = :CityId';
        $criteria->params = ['CityId' => $cityId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}