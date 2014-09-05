<?php
namespace application\models\attribute;

/**
 * Class Group
 * @package application\models\attribute
 *
 * @property int $Id
 * @property string $ModelName
 * @property int $ModelId
 * @property string $Title
 * @property string $Description
 * @property int $Order
 *
 * @property Definition[] $Definitions
 *
 * @method Group find($condition='',$params=array())
 * @method Group findByPk($pk,$condition='',$params=array())
 * @method Group[] findAll($condition='',$params=array())
 */

class Group extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Group
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AttributeGroup';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Definitions' => [self::HAS_MANY, '\application\models\attribute\Definition', 'GroupId'],
        ];
    }

    /**
     * @param $modelName
     * @param bool $useAnd
     * @return Group
     */
    public function byModelName($modelName, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ModelName" = :ModelName';
        $criteria->params = ['ModelName' => $modelName];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byModelId($modelId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ModelId" = :ModelId';
        $criteria->params = ['ModelId' => $modelId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
} 