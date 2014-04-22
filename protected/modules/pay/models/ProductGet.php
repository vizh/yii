<?php
namespace pay\models;

/**
 * Class ProductGet
 * @package pay\models
 * @property int $Id
 * @property int $UserId
 * @property int $ProductId
 * @property string $CreationTime
 */
class ProductGet extends \CActiveRecord
{
  /**
   * @param string $className
   * @return ProductGet
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayProductGet';
  }

  public function relations()
  {
    return [
      'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
    ];
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return $this
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $productId
   * @param bool $useAnd
   * @return $this
   */
  public function byProductId($productId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ProductId" = :ProductId';
    $criteria->params = array('ProductId' => $productId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
} 