<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OrderId
 * @property int $Code
 * @property string $Message
 * @property string $Info
 * @property string $PaySystem
 * @property bool $Error
 * @property int $Total
 * @property string $CreationTime
 *
 * @property Order $Order
 *
 * Описание вспомогательных методов
 * @method Log   with($condition = '')
 * @method Log   find($condition = '', $params = [])
 * @method Log   findByPk($pk, $condition = '', $params = [])
 * @method Log   findByAttributes($attributes, $condition = '', $params = [])
 * @method Log[] findAll($condition = '', $params = [])
 * @method Log[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Log byId(int $id, bool $useAnd = true)
 * @method Log byOrderId(int $id, bool $useAnd = true)
 * @method Log byCode(int $code, bool $useAnd = true)
 * @method Log byPaySystem(string $className, bool $useAnd = true)
 */
class Log extends ActiveRecord
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
        return 'PayLog';
    }

    public function relations()
    {
        return [
            'Order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId'],
        ];
    }
}
