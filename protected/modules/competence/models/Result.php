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
 * @property string $UpdateTime
 * @property bool $Finished
 * @property string $UserKey
 * @property \user\models\User $User
 *
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
    return [
      'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
    ];
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

  /**
   * @param string $userKey
   * @param bool $useAnd
   * @return Result
   */
  public function byUserKey($userKey, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserKey" = :UserKey';
    $criteria->params = array('UserKey' => $userKey);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byFinished($finished = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$finished ? 'NOT ' : '') . '"t"."Finished"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function setDataByResult($result)
  {
    $this->result = $result;
    $this->Data = base64_encode(serialize($result));
  }

  protected $result = null;
  /**
   * @return array
   */
  public function getResultByData()
  {
    if ($this->result === null)
    {
      $this->result = unserialize(base64_decode($this->Data));
    }
    return $this->result;
  }

  /**
   * @param Question $question
   *
   * @return array
   */
  public function getQuestionResult(Question $question)
  {
    return isset($this->getResultByData()[$question->Code]) ? $this->getResultByData()[$question->Code] : [];
  }

  /**
   * @param Question $question
   * @param array $data
   */
  public function setQuestionResult(Question $question, $data)
  {
    $result = $this->getResultByData();
    $result[$question->Code] = $data;
    $this->setDataByResult($result);
  }

  protected function beforeSave()
  {
    $this->UpdateTime = date('Y-m-d H:i:s');
    return parent::beforeSave();
  }


}