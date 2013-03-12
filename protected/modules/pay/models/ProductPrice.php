<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $ProductId
 * @property int $Price
 * @property string $StartTime
 * @property string $EndTime
 *
 *
 */
class ProductPrice extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayProductPrice';
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