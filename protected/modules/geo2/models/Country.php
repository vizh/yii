<?php
namespace geo2\models;

/**
 * @property int $Id
 * @property int $ExtId
 * @property string $Name
 * @property int $Priority
 * @property bool $CitiesParsed
 *
 * @method Country find($condition='',$params=array())
 * @method Country findByPk($pk,$condition='',$params=array())
 * @method Country[] findAll($condition='',$params=array())
 */
class Country extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Country
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Geo2Country';
    }

    public function primaryKey()
    {
        return 'Id';
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
}