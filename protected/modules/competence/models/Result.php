<?php
namespace competence\models;

/**
 * Class Result
 * @package competence\models
 *
 * @property int $Id
 * @property int $TestId
 * @property int $UserId
 * @property string $Data
 * @property string $CreationTime
 */
class Result extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Result
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompetenceResult';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }

  /**
   * @param int $testId
   * @param bool $useAnd
   * @return Result
   */
  public function byTestId($testId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."TestId" = :TestId';
    $criteria->params = array('TestId' => $testId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return Result
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function setDataByResult($result)
  {
    $this->Data = base64_encode(serialize($result));
  }
}