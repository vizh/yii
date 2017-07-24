<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EntryId
 * @property string $OrderNumber
 * @property int $OrderId
 * @property bool $Approved
 *
 * Описание вспомогательных методов
 * @method ImportOrder   with($condition = '')
 * @method ImportOrder   find($condition = '', $params = [])
 * @method ImportOrder   findByPk($pk, $condition = '', $params = [])
 * @method ImportOrder   findByAttributes($attributes, $condition = '', $params = [])
 * @method ImportOrder[] findAll($condition = '', $params = [])
 * @method ImportOrder[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ImportOrder byId(int $id, bool $useAnd = true)
 * @method ImportOrder byEntryId(int $id, bool $useAnd = true)
 * @method ImportOrder byOrderNumber(string $number, bool $useAnd = true)
 * @method ImportOrder byOrderId(int $id, bool $useAnd = true)
 * @method ImportOrder byApproved(bool $approved = true, bool $useAnd = true)
 */
class ImportOrder extends ActiveRecord
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
        return 'PayOrderImportOrder';
    }

    public function relations()
    {
        return [
            'entry' => [self::BELONGS_TO, '\pay\models\ImportEntry', 'EntryId'],
            'order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId']
        ];
    }
}
