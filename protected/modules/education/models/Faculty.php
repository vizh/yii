<?php
namespace education\models;

use application\components\utility\Texts;

/**
 * Class Faculty
 * @package education\models
 *
 * @property int $Id
 * @property int $ExtId
 * @property int $UniversityId
 * @property string $Name
 *
 * @property University $University
 *
 * @method Faculty find($condition='',$params=array())
 * @method Faculty findByPk($pk,$condition='',$params=array())
 * @method Faculty[] findAll($condition='',$params=array())
 */
class Faculty extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Faculty
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EducationFaculty';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'University' => [self::BELONGS_TO, 'education\models\University', 'UniversityId']
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
     * @param int $universityId
     * @param bool $useAnd
     * @return $this
     */
    public function byUniversityId($universityId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UniversityId" = :UniversityId';
        $criteria->params = ['UniversityId' => $universityId];
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
        $name = Texts::prepareStringForLike($name) . '%';
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" ILIKE :Name';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}