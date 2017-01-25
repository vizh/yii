<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $ProductId
 * @property string $Name
 * @property string $Value
 *
 * @property Product $Product
 *
 * Описание вспомогательных методов
 * @method ProductAttribute   with($condition = '')
 * @method ProductAttribute   find($condition = '', $params = [])
 * @method ProductAttribute   findByPk($pk, $condition = '', $params = [])
 * @method ProductAttribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method ProductAttribute[] findAll($condition = '', $params = [])
 * @method ProductAttribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ProductAttribute byId(int $id, bool $useAnd = true)
 * @method ProductAttribute byProductId(int $id, bool $useAnd = true)
 * @method ProductAttribute byName(string $name, bool $useAnd = true)
 */
class ProductAttribute extends ActiveRecord
{
    protected $useSoftDelete = true;

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
        return 'PayProductAttribute';
    }

    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
        ];
    }
}
