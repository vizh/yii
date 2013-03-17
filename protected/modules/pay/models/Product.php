<?php
namespace pay\models;


/**
 * @property int $Id
 * @property string $ManagerName
 * @property string $Title
 * @property string $Description
 * @property int $EventId
 * @property string $Unit
 * @property int $Count
 * @property int $EnableCoupon
 * @property bool $Public
 *
 * @property \event\models\Event $Event
 * @property ProductAttribute[] $Attributes
 * @property ProductPrice[] $Prices
 */
class Product extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Product
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayProduct';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Attributes' => array(self::HAS_MANY, '\pay\models\ProductAttribute', 'ProductId'),
      'Prices' => array(self::HAS_MANY, '\pay\models\ProductPrice', 'ProductId')
    );
  }

  /**
   * @var \pay\components\managers\BaseProductManager
   */
  private $manager = null;
  /**
   * @return \pay\components\managers\BaseProductManager
   */
  public function getManager()
  {
    if ($this->manager === null)
    {
      $manager = '\pay\components\managers\\' . $this->ManagerName;
      $this->manager = new $manager($this);
    }
    return $this->manager;
  }

  /** @var ProductAttribute[] */
  protected $productAttributes = null;

  /**
   * @return ProductAttribute[]
   */
  public function getProductAttributes()
  {
    if ($this->productAttributes === null)
    {
      $this->productAttributes = array();
      foreach ($this->Attributes as $attribute)
      {
        $this->productAttributes[$attribute->Name] = $attribute;
      }
    }

    return $this->productAttributes;
  }

  /**
   * @param ProductAttribute $attribute
   */
  public function setProductAttribute($attribute)
  {
    $this->productAttributes[$attribute->Name] = $attribute;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   *
   * @return Product
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * 
   * @param bool $public
   * @param bool $useAnd
   * @return \pay\models\Product
   */
  public function byPublic($public, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($public ? '' : 'NOT ') . '"t"."Public"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * @param string $managerName
   * @param bool $useAnd
   *
   * @return Product
   */
  public function byManagerName($managerName, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Manager" = :Manager';
    $criteria->params = array('Manager' => $managerName);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function getPrice($time = null)
  {
    $time = $time === null ? date('Y-m-d H:i:s', time()) : $time;
    foreach ($this->Prices as $price)
    {
      if ($price->StartTime <= $time && ($price->EndTime == null || $time < $price->EndTime))
      {
        return $price->Price;
      }
    }

    throw new \pay\components\Exception('Не удалось определить цену продукта!');
  }

}