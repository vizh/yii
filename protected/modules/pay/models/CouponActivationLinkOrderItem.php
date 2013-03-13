<?php
namespace pay\models;

/**
 * @property int $LinkId
 * @property int $CouponActivationId
 * @property int $OrderItemId
 *
 * @property CouponActivation $CouponActivation
 * @property OrderItem $OrderItem
 */
class CouponActivationLinkOrderItem extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayCouponActivationLinkOrderItem';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'CouponActivation' => array(self::BELONGS_TO, '\pay\models\CouponActivation', 'CouponActivationId'),
      'OrderItem' => array(self::BELONGS_TO, '\pay\models\OrderItem', 'OrderItemId')
    );
  }
}