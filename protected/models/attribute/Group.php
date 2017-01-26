<?php
namespace application\models\attribute;

use application\components\ActiveRecord;
use application\components\CDbCriteria;

/**
 * Class Group
 *
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
 * @method Group byModelId($condition = '', $useAnd = true)
 * @method Group byModelName($condition = '', $useAnd = true)
 *
 * Описание вспомогательных методов
 * @method Group   with($condition = '')
 * @method Group   find($condition = '', $params = [])
 * @method Group   findByPk($pk, $condition = '', $params = [])
 * @method Group   findByAttributes($attributes, $condition = '', $params = [])
 * @method Group[] findAll($condition = '', $params = [])
 * @method Group[] findAllByAttributes($attributes, $condition = '', $params = [])
 */
class Group extends ActiveRecord
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

    protected function beforeFind()
    {
        $this->getDbCriteria()->mergeWith(
            CDbCriteria::create()
                ->setOrder('"t"."Order"')
        );
    }

}