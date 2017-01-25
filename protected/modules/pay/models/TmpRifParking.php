<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Brand
 * @property string $Model
 * @property string $Number
 * @property string $Hotel
 * @property string $DateIn
 * @property string $DateOut
 * @property string $Status
 *
 * Описание вспомогательных методов
 * @method TmpRifParking   with($condition = '')
 * @method TmpRifParking   find($condition = '', $params = [])
 * @method TmpRifParking   findByPk($pk, $condition = '', $params = [])
 * @method TmpRifParking   findByAttributes($attributes, $condition = '', $params = [])
 * @method TmpRifParking[] findAll($condition = '', $params = [])
 * @method TmpRifParking[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method TmpRifParking byId(int $id, bool $useAnd = true)
 * @method TmpRifParking byEventId(int $id, bool $useAnd = true)
 */
class TmpRifParking extends ActiveRecord
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
        return 'TmpRifParking';
    }
}