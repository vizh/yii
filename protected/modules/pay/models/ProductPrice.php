<?php
namespace pay\models;

use application\models\translation\ActiveRecord;

/**
 * Class ProductPrice
 *
 * @property int $Id
 * @property int $ProductId
 * @property int $Price
 * @property string $StartTime
 * @property string $EndTime
 * @property string $Title
 *
 * @method ProductPrice byDeleted(boolean $deleted)
 */
class ProductPrice extends ActiveRecord
{
    protected $useSoftDelete = true;

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

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayProductPrice';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, 'pay\models\Product', 'ProductId']
        ];
    }

    /**
     * @inheritdoc
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }
}
