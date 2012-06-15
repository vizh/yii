<?php

/**
 * @property int $ResultId
 * @property int $UserId
 * @property int $VoteId
 * @property int $QuestionId
 * @property int $AnswerId
 *
 * @property User $User
 */
class ComissionVoteResult extends CActiveRecord
{
public static $TableName = 'Mod_ComissionVoteResult';

  /**
  * @param string $className
  * @return JobTestQuestion
  */
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
    return 'ResultId';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return ComissionVoteResult
   */
  public static function GetById($id)
  {
    return ComissionVoteResult::model()->findByPk($id);
  }

  /**
   * @static
   * @param int $voteId
   * @param int $userId
   * @return ComissionVoteResult[]
   */
  public static function GetByVoteAndUser($voteId, $userId)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.VoteId = :VoteId AND t.UserId = :UserId';
    $criteria->params = array(':VoteId' => $voteId, ':UserId' => $userId);
    return ComissionVoteResult::model()->findAll($criteria);
  }
}
