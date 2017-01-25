<?php
namespace ruvents\models;

use application\components\ActiveRecord;

/**
 * @property int $EventSettingId
 * @property int $EventId
 * @property string $Name
 * @property string $DataBuilder
 *
 * Описание вспомогательных методов
 * @method EventSetting   with($condition = '')
 * @method EventSetting   find($condition = '', $params = [])
 * @method EventSetting   findByPk($pk, $condition = '', $params = [])
 * @method EventSetting   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventSetting[] findAll($condition = '', $params = [])
 * @method EventSetting[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventSetting byId(int $id, bool $useAnd = true)
 * @method EventSetting byEventId(int $id, bool $useAnd = true)
 * @method EventSetting byEventSettingId(int $id, bool $useAnd = true)
 * @method EventSetting byName(string $name, bool $useAnd = true)
 * @method EventSetting byDataBuilder(string $builder, bool $useAnd = true)
 */
class EventSetting extends ActiveRecord
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
        return 'Mod_RuventsEventSetting';
    }

    public function primaryKey()
    {
        return 'EventSettingId';
    }
}