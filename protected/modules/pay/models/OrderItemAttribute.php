<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OrderItemId
 * @property string $Name
 * @property string $Value
 *
 * Описание вспомогательных методов
 * @method OrderItemAttribute   with($condition = '')
 * @method OrderItemAttribute   find($condition = '', $params = [])
 * @method OrderItemAttribute   findByPk($pk, $condition = '', $params = [])
 * @method OrderItemAttribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method OrderItemAttribute[] findAll($condition = '', $params = [])
 * @method OrderItemAttribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method OrderItemAttribute byId(int $id, bool $useAnd = true)
 * @method OrderItemAttribute byOrderItemId(int $id, bool $useAnd = true)
 * @method OrderItemAttribute byName(string $name, bool $useAnd = true)
 */
class OrderItemAttribute extends ActiveRecord
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
        return 'PayOrderItemAttribute';
    }
}
