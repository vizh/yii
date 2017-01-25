<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property string $Name
 * @property string $Value
 *
 * Описание вспомогательных методов
 * @method EventUserAdditionalAttribute   with($condition = '')
 * @method EventUserAdditionalAttribute   find($condition = '', $params = [])
 * @method EventUserAdditionalAttribute   findByPk($pk, $condition = '', $params = [])
 * @method EventUserAdditionalAttribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventUserAdditionalAttribute[] findAll($condition = '', $params = [])
 * @method EventUserAdditionalAttribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventUserAdditionalAttribute byId(int $id, bool $useAnd = true)
 * @method EventUserAdditionalAttribute byEventId(int $id, bool $useAnd = true)
 * @method EventUserAdditionalAttribute byUserId(int $id, bool $useAnd = true)
 * @method EventUserAdditionalAttribute byName(string $name, bool $useAnd = true)
 */
class EventUserAdditionalAttribute extends ActiveRecord
{
    /**
     * @param string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventUserAdditionalAttribute';
    }
}