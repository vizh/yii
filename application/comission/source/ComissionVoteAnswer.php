<?php


/**
 * @property int $AnswerId
 * @property int $QuestionId
 * @property string $Answer
 *
 * @property ComissionVoteQuestion $Question
 * @property ComissionVoteResult[] $Results
 */
class ComissionVoteAnswer extends CActiveRecord
{
  public static $TableName = 'Mod_ComissionVoteAnswer';

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
    return 'AnswerId';
  }

  public function relations()
  {
    return array(
      'Question' => array(self::BELONGS_TO, 'ComissionVoteQuestion', 'QuestionId'),
      'Results' => array(self::HAS_MANY, 'ComissionVoteResult', 'AnswerId')
    );
  }

  /**
   * @static
   * @param int $id
   * @return JobTestQuestion
   */
  public static function GetById($id)
  {
    return ComissionVoteAnswer::model()->findByPk($id);
  }
}
