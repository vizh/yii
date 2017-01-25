<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $PayLogId
 * @property string $OrderId
 * @property string $Message
 * @property int $Code
 * @property string $Info
 * @property string $PaySystem
 * @property string $Type
 * @property int $Total
 * @property string $CreationTime
 *
 * @property Order $Order
 *
 * Описание вспомогательных методов
 * @method PayLog   with($condition = '')
 * @method PayLog   find($condition = '', $params = [])
 * @method PayLog   findByPk($pk, $condition = '', $params = [])
 * @method PayLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method PayLog[] findAll($condition = '', $params = [])
 * @method PayLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method PayLog byPayLogId(int $id, bool $useAnd = true)
 * @method PayLog byOrderId(int $id, bool $useAnd = true)
 * @method PayLog byCode(int $code, bool $useAnd = true)
 */
class PayLog extends ActiveRecord
{
    const TypeSuccess = 'success';
    const TypeError = 'error';

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
        return 'Mod_PayLog';
    }

    public function primaryKey()
    {
        return 'PayLogId';
    }

    public function relations()
    {
        return [
            'Order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId'],
        ];
    }
}
