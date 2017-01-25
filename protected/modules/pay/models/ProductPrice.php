<?php
namespace pay\models;

use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property int $ProductId
 * @property int $Price
 * @property string $StartTime
 * @property string $EndTime
 * @property string $Title
 * @property bool $Deleted
 * @property bool $DeletionTime
 *
 * Описание вспомогательных методов
 * @method ProductPrice   with($condition = '')
 * @method ProductPrice   find($condition = '', $params = [])
 * @method ProductPrice   findByPk($pk, $condition = '', $params = [])
 * @method ProductPrice   findByAttributes($attributes, $condition = '', $params = [])
 * @method ProductPrice[] findAll($condition = '', $params = [])
 * @method ProductPrice[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ProductPrice byId(int $id, bool $useAnd = true)
 * @method ProductPrice byProductId(int $id, bool $useAnd = true)
 * @method ProductPrice byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class ProductPrice extends ActiveRecord
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

    /**
     * Creates a new one model
     *
     * @param Product|int $product Product's model or the product identifier
     * @param int $price The price of the product in Rubles
     * @param string $name The name of the product
     * @param string $startTime The start time of the price, it must be in the PostgreSQL compatible format,
     * for example 2016-04-12 12:34:12
     * @param string $endTime The start time of the price, it must be in the PostgreSQL compatible format,
     * for example 2016-04-12 12:34:12
     * @return self|null
     */
    public static function create($product, $price, $name = null, $startTime = null, $endTime = null)
    {
        if ($product instanceof Product) {
            $product = $product->Id;
        }

        try {
            $model = new self();
            $model->ProductId = $product;
            $model->Price = $price;
            $model->StartTime = $startTime;
            $model->EndTime = $endTime;
            $model->Title = $name;

            $model->save();

            return $model;
        } catch (\CDbException $e) {
        }
    }

    public function tableName()
    {
        return 'PayProductPrice';
    }

    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, 'pay\models\Product', 'ProductId']
        ];
    }

    public function getTranslationFields()
    {
        return ['Title'];
    }
}
