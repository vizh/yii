<?php
namespace application\models\attribute;

/**
 * Class Definition
 * @package application\models\attribute
 *
 * @property int $Id
 * @property int $GroupId
 * @property string $ClassName
 * @property string $Name
 * @property string $Title
 * @property boolean $Required
 * @property boolean $Secure
 * @property string $Params
 * @property int $Order
 *
 * @method Definition find($condition='',$params=array())
 * @method Definition findByPk($pk,$condition='',$params=array())
 * @method Definition[] findAll($condition='',$params=array())
 */
class Definition extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Definition
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AttributeDefinition';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Group' => [self::BELONGS_TO, '\application\models\attribute\Group', 'GroupId']
        ];
    }

    /**
     * @param $modelName
     * @param bool $useAnd
     * @return Definition
     */
    public function byModelName($modelName, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Group"."ModelName" = :ModelName';
        $criteria->params = ['ModelName' => $modelName];
        $criteria->with = ['Group' => ['together' => true]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param $modelId
     * @param bool $useAnd
     * @return Definition
     */
    public function byModelId($modelId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Group"."ModelId" = :ModelId';
        $criteria->params = ['ModelId' => $modelId];
        $criteria->with = ['Group' => ['together' => true]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @return Definition
     */
    public function ordered()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Group' => ['together' => true]];
        $criteria->order = '"Group"."Order", "t"."Order"';
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    private $cachedParams = null;


    public function getParams()
    {
        if ($this->cachedParams === null) {
            $this->cachedParams = $this->Params !== null ? json_decode($this->Params, true) : [];
        }
        return $this->cachedParams;
    }

    public function setParams(array $params = [])
    {
        $this->cachedParams = $params;
        $this->Params = count($params) > 0 ? json_encode($params, JSON_UNESCAPED_UNICODE) : null;
    }
} 