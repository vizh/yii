<?php
namespace pay\models;

/**
 * @property int $ProductAttributeId
 * @property int $ProductId
 * @property string $Name
 * @property string $Value
 */
class ProductAttribute extends \CActiveRecord
{
  public static $TableName = 'Mod_PayProductAttribute';

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
    return 'ProductAttributeId';
  }

  public function relations()
  {
    return array(
      'Product' => array(self::BELONGS_TO, 'Product', 'ProductId')
    );
  }
}
