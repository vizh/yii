<?php
namespace education\models;

use application\components\ActiveRecord;
use application\components\utility\Texts;

/**
 * Class Faculty
 *
 * @package education\models
 *
 * @property int $Id
 * @property int $ExtId
 * @property int $UniversityId
 * @property string $Name
 *
 * @property University $University
 *
 * Описание вспомогательных методов
 * @method Faculty   with($condition = '')
 * @method Faculty   find($condition = '', $params = [])
 * @method Faculty   findByPk($pk, $condition = '', $params = [])
 * @method Faculty   findByAttributes($attributes, $condition = '', $params = [])
 * @method Faculty[] findAll($condition = '', $params = [])
 * @method Faculty[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Faculty byId(int $id, bool $useAnd = true)
 * @method Faculty byExtId(int $id, bool $useAnd = true)
 * @method Faculty byUniversityId(int $id, bool $useAnd = true)
 */
class Faculty extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EducationFaculty';
    }

    public function relations()
    {
        return [
            'University' => [self::BELONGS_TO, 'education\models\University', 'UniversityId']
        ];
    }

    /**
     * @param string $name
     * @param bool $useAnd
     * @return $this
     */
    public function byName($name, $useAnd = true)
    {
        $name = Texts::prepareStringForLike($name).'%';
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" ILIKE :Name';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}