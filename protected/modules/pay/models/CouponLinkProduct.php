<?php
namespace pay\models;

/**
 * Class CouponLinkProduct
 * @package pay\models
 * @property integer $CouponId
 * @property integer $ProductId
 */
class CouponLinkProduct extends \CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayCouponLinkProduct';
    }

    public function primaryKey()
    {
        return ['CouponId', 'ProductId'];
    }
} 