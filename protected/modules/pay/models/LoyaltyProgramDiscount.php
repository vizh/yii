<?php
namespace pay\models;

/**
 * Class LoyaltyProgramDiscount
 * @package pay\models
 * @property int $Id
 * @property int $ProductId
 * @property double $Discount
 * @property string $StartTime
 * @property string $EndTime
 * @property int $EventId
 * @property string $CreationTime
 * @property Product $Product;
 *
 * @method \pay\models\LoyaltyProgramDiscount findByPk()
 * @method \pay\models\LoyaltyProgramDiscount find()
 * @method \pay\models\LoyaltyProgramDiscount[] findAll()
 */
class LoyaltyProgramDiscount extends \CActiveRecord
{
  const StatusEnd    = -1;
  const StatusActive =  1;
  const StatusSoon   =  0;


  /**
   * @param string $className
   * @return LoyaltyProgramDiscount
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayLoyaltyProgramDiscount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
    ];
  }


  /**
   * @param int $productId
   * @param bool $useAnd
   * @return $this
   */
  public function byProductId($productId, $orIsNull = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ProductId" = :ProductId'. ($orIsNull ? ' OR "t"."ProductId" IS NULL' : ''));
    $criteria->params['ProductId'] = $productId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return $this
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."EventId" = :EventId');
    $criteria->params['EventId'] = $eventId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $useAnd
   * @return $this
   */
  public function byActual($useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."StartTime" IS NULL OR "t"."StartTime" <= NOW()');
    $criteria->addCondition('"t"."EndTime" IS NULL OR "t"."EndTime" >= NOW()');
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @return int
   */
  public function getStatus()
  {
    $status = self::StatusSoon;
    $currentDate = date('Y-m-d H:i:s');
    if ($this->EndTime !== null && $this->EndTime < $currentDate)
    {
      $status = self::StatusEnd;
    }
    elseif (($this->StartTime == null || $this->StartTime < $currentDate) && ($this->EndTime == null || $this->EndTime > $currentDate))
    {
      $status = self::StatusActive;
    }
    return $status;
  }
} 