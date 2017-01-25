<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OrderId
 * @property string $Name
 * @property string $Address
 * @property string $INN
 * @property string $KPP
 * @property string $Phone
 * @property string $Fax
 * @property string $PostAddress
 * @property string $ExternalKey
 * @property string $UrlPay
 *
 * @property Order $Order
 *
 * Описание вспомогательных методов
 * @method OrderJuridical   with($condition = '')
 * @method OrderJuridical   find($condition = '', $params = [])
 * @method OrderJuridical   findByPk($pk, $condition = '', $params = [])
 * @method OrderJuridical   findByAttributes($attributes, $condition = '', $params = [])
 * @method OrderJuridical[] findAll($condition = '', $params = [])
 * @method OrderJuridical[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method OrderJuridical byId(int $id, bool $useAnd = true)
 * @method OrderJuridical byOrderId(int $id, bool $useAnd = true)
 */
class OrderJuridical extends ActiveRecord
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
        return 'PayOrderJuridical';
    }

    public function relations()
    {
        return [
            'Order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId'],
        ];
    }
}