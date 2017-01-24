<?php
namespace education\models;

use application\components\ActiveRecord;
use application\components\utility\Texts;
use geo\models\City;

/**
 * Class University
 *
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
 * Описание вспомогательных методов
 * @method University   with($condition = '')
 * @method University   find($condition = '', $params = [])
 * @method University   findByPk($pk, $condition = '', $params = [])
 * @method University   findByAttributes($attributes, $condition = '', $params = [])
 * @method University[] findAll($condition = '', $params = [])
 * @method University[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method University byId(int $id, bool $useAnd = true)
 * @method University byExtId(int $id, bool $useAnd = true)
 * @method University byCityId(int $id, bool $useAnd = true)
 */
class University extends ActiveRecord
{
    /**
     * @param string $className
     * @return University
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EducationUniversity';
    }

    public function relations()
    {
        return [
            'City' => [self::BELONGS_TO, City::className(), 'CityId']
        ];
    }

    /**
     * @param string $name
     * @param bool $useAnd
     * @return $this
     */
    public function byName($name, $useAnd = true)
    {
        $name = '%'.Texts::prepareStringForLike($name).'%';
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" ILIKE :Name';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}