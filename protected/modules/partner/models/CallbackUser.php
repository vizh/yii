<?php
namespace partner\models;

/**
 * Class CallbackUser
 * @package partner\models
 *
 * @property int $Id
 * @property int $PartnerCallbackId
 * @property int $UserId
 * @property string $Key
 * @property string $CreationTime
 *
 * @property PartnerCallback $PartnerCallback
 *
 * @method \partner\models\CallbackUser find($condition='',$params=array())
 * @method \partner\models\CallbackUser findByPk($pk,$condition='',$params=array())
 * @method \partner\models\CallbackUser[] findAll($condition='',$params=array())
 */
class CallbackUser extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return CallbackUser
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerCallbackUser';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'PartnerCallback' => [self::BELONGS_TO, 'partner\models\PartnerCallback', 'PartnerCallbackId']
    ];
  }

  /**
   * @param int $callbackId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byPartnerCallbackId($callbackId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."PartnerCallbackId" = :PartnerCallbackId';
    $criteria->params = ['PartnerCallbackId' => $callbackId];
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

  /**
   * @param string $key
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byKey($key, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Key" = :Key';
    $criteria->params = ['Key' => $key];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $creationTime
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byCreationTimeBefore($creationTime, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."CreationTime" < :CreationTimeBefore';
    $criteria->params = ['CreationTimeBefore' => $creationTime];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $creationTime
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byCreationTimeFrom($creationTime, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."CreationTime" > :CreationTimeFrom';
    $criteria->params = ['CreationTimeFrom' => $creationTime];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $creationTime
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byCreationTimeTo($creationTime, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."CreationTime" < :CreationTimeTo';
    $criteria->params = ['CreationTimeTo' => $creationTime];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}