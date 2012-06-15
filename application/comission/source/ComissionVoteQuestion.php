<?php

/**
 * @property int $QuestionId
 * @property int $VoteId
 * @property string $Question
 *
 * @property ComissionVote $Vote
 * @property ComissionVoteAnswer[] $Answers
 */
class ComissionVoteQuestion extends CActiveRecord
{
  public static $TableName = 'Mod_ComissionVoteQuestion';

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
    return 'QuestionId';
  }

  public function relations()
  {
    return array(
      'Vote' => array(self::BELONGS_TO, 'ComissionVote', 'VoteId'),
      'Answers' => array(self::HAS_MANY, 'ComissionVoteAnswer', 'QuestionId', 'order' => 'Answers.AnswerId ASC')
    );
  }

  public function beforeDelete()
  {
    ComissionVoteAnswer::model()->deleteAll('QuestionId = :QuestionId', array(':QuestionId' => $this->QuestionId));
    return parent::beforeDelete();
  }

  /**
   * @static
   * @param int $id
   * @return JobTestQuestion
   */
  public static function GetById($id)
  {
    return ComissionVoteQuestion::model()->findByPk($id);
  }
}
