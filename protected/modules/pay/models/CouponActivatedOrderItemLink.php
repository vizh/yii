<?php
namespace pay\models;

/**
 * @property int $LinkId
 * @property int $CouponActivatedId
 * @property int $OrderItemId
 */
class CouponActivatedOrderItemLink extends \CActiveRecord
{
  public static $TableName = 'Mod_PayCouponActivatedOrderItemLink';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'LinkId';
  }

  public function relations()
  {
    return array( );
  }
}