<?php
namespace pay\models;

/**
 * @property int $ProductPriceId
 * @property int $ProductId
 * @property int $Price
 * @property string $StartTime
 * @property string $EndTime
 *
 *
 */
class ProductPrice extends \CActiveRecord
{
  public static $TableName = 'Mod_PayProductPrice';

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
    return 'ProductPriceId';
  }

  public function relations()
  {
    return array(
      'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId')
    );
  }
}