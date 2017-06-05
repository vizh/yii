<?php
namespace application\models\translation;

/**
 * @property int $Id
 * @property string $ResourceName
 * @property int $ResourceId
 * @property string $Locale
 * @property string $Field
 * @property string $Value
 */
class Translation extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Translation
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Translation';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [];
    }

    /**
     * @param string $resourceName
     * @param bool $useAnd
     * @return Translation
     */
    public function byResourceName($resourceName, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ResourceName" = :ResourceName';
        $criteria->params = [':ResourceName' => $resourceName];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $resourceId
     * @param bool $useAnd
     * @return Translation
     */
    public function byResourceId($resourceId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ResourceId" = :ResourceId';
        $criteria->params = [':ResourceId' => $resourceId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}