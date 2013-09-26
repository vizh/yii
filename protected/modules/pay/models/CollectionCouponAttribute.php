<?php
namespace pay\models;

/**
 * Class CollectionCouponAttribute
 * @package pay\models
 *
 * @property int $Id
 * @property int $CollectionCouponId
 * @property string $Name
 * @property string $Value
 */
class CollectionCouponAttribute extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return CollectionCouponAttribute
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayCollectionCouponAttribute';
  }

  public function primaryKey()
  {
    return 'Id';
  }
}