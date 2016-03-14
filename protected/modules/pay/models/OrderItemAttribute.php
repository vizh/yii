<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * Class OrderItemAttribute uses for storing data attributes for order items
 *
 * Fields
 * @property int $Id
 * @property int $OrderItemId
 * @property string $Name
 * @property string $Value
 */
class OrderItemAttribute extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayOrderItemAttribute';
    }
}
