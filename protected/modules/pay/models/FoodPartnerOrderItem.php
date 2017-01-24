<?php
namespace pay\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "PayFoodPartnerOrderItem".
 *
 * The followings are the available columns in table 'PayFoodPartnerOrderItem':
 * @property integer $Id
 * @property integer $ProductId
 * @property bool $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property integer $OrderId
 * @property integer $Count
 *
 *
 * The followings are the available model relations:
 * @property FoodPartnerOrder $Order
 * @property Product $Product
 *
 * @method FoodPartnerOrderItem byOrderId(int $orderId)
 * @method FoodPartnerOrderItem byProductId(int $productId)
 */

class FoodPartnerOrderItem extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FoodPartnerOrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PayFoodPartnerOrderItem';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'Order' => [self::BELONGS_TO, '\pay\models\FoodPartnerOrder', 'OrderId'],
			'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
		];
	}
}