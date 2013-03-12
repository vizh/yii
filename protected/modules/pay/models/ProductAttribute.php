<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $ProductId
 * @property string $Name
 * @property string $Value
 */
class ProductAttribute extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayProductAttribute';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId')
    );
  }
}
