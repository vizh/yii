<?php
namespace pay\models;

/**
 * Class ProductUserAccess
 * @package pay\models
 *
 * @property int $Id
 * @property int $ProductId
 * @property int $UserId
 * @property string $CreationTime
 *
 * @property Product $Product
 * @property \user\models\User $User
 */
class ProductUserAccess extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return ProductUserAccess
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayProductUserAccess';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId'],
      'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
    );
  }

  /**
   * @param int[] $productsId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byProductId($productsId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."ProductId"', $productsId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = ['UserId' => $userId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}