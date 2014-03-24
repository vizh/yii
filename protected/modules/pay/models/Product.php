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
 * @property bool $EnableCoupon
 * @property bool $Public
 * @property int $Priority
 * @property string $AdditionalAttributes
 *
 * @property \event\models\Event $Event
 * @property ProductAttribute[] $Attributes
 * @property ProductPrice[] $Prices
 * @property ProductPrice[] $PricesActive
 *
 *
 * @method \pay\models\Product find($condition='',$params=array())
 * @method \pay\models\Product findByPk($pk,$condition='',$params=array())
 * @method \pay\models\Product[] findAll($condition='',$params=array())
 *
 */
class Product extends \application\models\translation\ActiveRecord
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
      'Prices' => array(self::HAS_MANY, '\pay\models\ProductPrice', 'ProductId', 'order' => '"Prices"."StartTime" ASC'),
      'PricesActive' => [self::HAS_MANY, '\pay\models\ProductPrice', 'ProductId', 'order' => '"PricesActive"."StartTime" ASC', 'condition' => '"PricesActive"."EndTime" IS NULL OR "PricesActive"."EndTime" >  now()'],
      'UserAccess' => [self::HAS_MANY, '\pay\models\ProductUserAccess', 'ProductId']
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
   * @param int $userId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byUserAccess($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['UserAccess' => ['together' => true, 'select' => false]];
    $criteria->condition = '"UserAccess"."UserId" = :UserId';
    $criteria->params = ['UserId' => $userId];
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
    $criteria->condition = '"t"."ManagerName" = :ManagerName';
    $criteria->params = array('ManagerName' => $managerName);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $time
   * @return int
   */
  public function getPrice($time = null)
  {
    return $this->getManager()->getPriceByTime($time);
  }

  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return ['Title', 'Description'];
  }

  /**
   * @return AdditionalAttribute[]
   */
  public function getAdditionalAttributes()
  {
    if ($this->AdditionalAttributes == null)
    {
      return [];
    }
    return unserialize(base64_decode($this->AdditionalAttributes));
  }

  /**
   * @param AdditionalAttribute[] $attributes
   */
  public function setAdditionalAttributes($attributes)
  {
    $this->AdditionalAttributes = base64_encode(serialize($attributes));
  }
}