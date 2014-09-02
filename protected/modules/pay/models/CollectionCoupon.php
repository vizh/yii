<?php
namespace pay\models;

/**
 * Class CollectionCoupon
 * @package pay\models
 *
 * @property int $Id
 * @property int $EventId
 * @property string $Type
 * @property float $Discount
 * @property string $CreationTime
 * @property string $StartTime
 * @property string $EndTime
 *
 * @property \event\models\Event $Event
 * @property CollectionCouponAttribute[] $Attributes
 */
class CollectionCoupon extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return CollectionCoupon
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayCollectionCoupon';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Attributes' => array(self::HAS_MANY, '\pay\models\CollectionCouponAttribute', 'CollectionCouponId')
    );
  }

  /** @var CollectionCouponAttribute[] */
  protected $couponAttributes = null;

  /**
   * @return CollectionCouponAttribute[]
   */
  public function getCouponAttributes()
  {
    if ($this->couponAttributes === null)
    {
      $this->couponAttributes = [];
      foreach ($this->Attributes as $attribute)
      {
        $this->couponAttributes[$attribute->Name] = $attribute;
      }
    }

    return $this->couponAttributes;
  }

  /**
   * @param $eventId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = ['EventId' => $eventId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @var \pay\components\collection\coupons\Base
   */
  private $typeManager = null;
  /**
   * @return \pay\components\collection\coupons\Base
   */
  public function getTypeManager()
  {
    if ($this->typeManager === null)
    {
      $type = '\pay\components\collection\coupons\\' . $this->Type;
      $this->typeManager = new $type($this);
    }
    return $this->typeManager;
  }

  /**
   * Активен ли купон
   * @param string $dateTime Дата и время в формате воспринимаемом функцией date_parse
   * @return bool
   * @throws \CException
   */
  public function isActive($dateTime = null)
  {
    if (empty($dateTime))
      $dateTime = date('Y-m-d H:i:s');
    else
    {
      $dateParsed = date_parse($dateTime);
      if (!empty($dateParsed['errors']))
        throw new \CException('Передан неверный формат даты!');

      $dateTime = mktime($dateParsed['hour'], $dateParsed['minute'], $dateParsed['second'],
        $dateParsed['month'], $dateParsed['day'], $dateParsed['year']);

      $dateTime = date('Y-m-d H:i:s', $dateTime);
    }

    if (empty($this->StartTime) && empty($this->EndTime))
      return true;
    if (empty($this->EndTime) && $dateTime >= $this->StartTime)
      return true;
    if (empty($this->StartTime) && $dateTime <= $this->EndTime)
      return true;
    if ($dateTime >= $this->StartTime && $dateTime <= $this->EndTime)
      return true;

    return false;
  }
}