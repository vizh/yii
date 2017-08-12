<?php
namespace application\models\attribute;

use application\models\translation\ActiveRecord;

/**
 * Class Definition
 *
 * Fields
 * @property int $Id
 * @property int $GroupId
 * @property string $ClassName
 * @property string $Name
 * @property string $Title
 * @property bool $Required
 * @property bool $Secure
 * @property string $Params
 * @property bool $UseCustomTextField Whether use the custom option (text field) for list definitions
 * @property int $Order
 * @property bool $Public
 * @property bool $Translatable
 *
 * @method Definition find($condition = '', $params = [])
 * @method Definition findByPk($pk, $condition = '', $params = [])
 * @method Definition[] findAll($condition = '', $params = [])
 *
 * @method Definition byPublic(bool $public)
 * @method Definition byGroupId(int $id)
 */
class Definition extends ActiveRecord
{
    /**
     * @param string $className
     * @return Definition
     */
    public static function model($className = __CLASS__)
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
     * @param string $className
     * @param bool $useAnd
     * @return Definition
     */
    public function byClassName($className, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"ClassName" = :ClassName';
        $criteria->params = ['ClassName' => $className];
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
        $criteria->order = '"Group"."Order", "t"."Order", "t"."Id"';
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    private $cachedParams;

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

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }
}
