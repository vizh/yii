<?php
namespace pay\models;

/**
 * Class CouponLinkProduct
 * @package pay\models
 * @property integer $CollectionCouponId
 * @property integer $ProductId
 */
class CollectionCouponLinkProduct extends \CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayCollectionCouponLinkProduct';
    }

    public function primaryKey()
    {
        return ['CollectionCouponId', 'ProductId'];
    }
} 