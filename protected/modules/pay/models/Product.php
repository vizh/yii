<?php
namespace pay\models;


/**
 * @property int $ProductId
 * @property string $Manager
 * @property string $Title
 * @property string $Description
 * @property int $EventId
 * @property string $Unit
 * @property int $Count
 * @property int $EnableCoupon
 *
 * @property \event\models\Event $Event
 * @property ProductAttribute[] $Attributes
 * @property ProductPrice[] $Prices
 */
class Product extends \CActiveRecord
{
  public static $TableName = 'Mod_PayProduct';

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
    return 'ProductId';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      'Attributes' => array(self::HAS_MANY, 'ProductAttribute', 'ProductId'),
      'Prices' => array(self::HAS_MANY, 'ProductPrice', 'ProductId')
    );
  }

  public function AddAttribute($name, $value)
  {
    $attribute = new ProductAttribute();
    $attribute->ProductId = $this->ProductId;
    $attribute->Name = $name;
    $attribute->Value = $value;
    $attribute->save();

    return $attribute;
  }

  private $attributesCache = null;
  /**
   * @param $name
   * @return ProductAttribute|null
   */
  public function GetAttribute($name)
  {
    if ($this->attributesCache == null)
    {
      $this->attributesCache = array();
      foreach ($this->Attributes as $attribute)
      {
        $this->attributesCache[$attribute->Name] = $attribute;
      }
    }
    return isset($this->attributesCache[$name]) ? $this->attributesCache[$name] : null;
  }

  public function AddPrice($price, $startTime, $endTime = null)
  {
    $productPrice = new ProductPrice();
    $productPrice->ProductId = $this->ProductId;
    $productPrice->Price = $price;
    $productPrice->StartTime = $startTime;
    $productPrice->EndTime = $endTime;
    $productPrice->save();

    return $productPrice;
  }

  /**
   * @var \pay\models\managers\BaseProductManager
   */
  private $productManager;
  /**
   * @return \pay\models\managers\BaseProductManager
   */
  public function ProductManager()
  {
    if (empty($this->productManager))
    {
      $manager = $this->Manager;
      $this->productManager = new $manager($this);
    }
    return $this->productManager;
  }

  /**
   * @static
   * @param int $id
   * @return Product
   */
  public static function GetById($id)
  {
    return Product::model()->with('Attributes')->findByPk($id);
  }

  /**
   * @static
   * @param int $eventId
   * @return Product[]
   */
  public static function GetByEventId($eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);

    return Product::model()->findAll($criteria);
  }

  /**
   * @static
   * @param string $managerName
   * @param int $eventId
   * @return Product|null
   */
  public static function GetByManager($managerName, $eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Manager = :Manager AND t.EventId = :EventId';
    $criteria->params = array(':Manager' => $managerName, ':EventId' => $eventId);

    return Product::model()->find($criteria);
  }

  /**
   * @param string|null $time
   * @return int|null
   */
  public function GetPrice($time = null)
  {
    $time = $time === null ? date('Y-m-d H:i:s', time()) : $time;
    foreach ($this->Prices as $price)
    {
      if ($price->StartTime <= $time && ($price->EndTime == null || $time < $price->EndTime))
      {
        return $price->Price;
      }
    }
    return null;
  }
}
