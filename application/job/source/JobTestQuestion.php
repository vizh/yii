<?php

/**
 * @property int $QuestionId
 * @property int $TestId
 * @property string $Question
 *
 * @property JobTest $Test
 * @property JobTestAnswer[] $Answers
 */
class JobTestQuestion extends CActiveRecord
{
  public static $TableName = 'Mod_JobTestQuestion';

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
      'Test' => array(self::BELONGS_TO, 'JobTest', 'TestId'),
      'Answers' => array(self::HAS_MANY, 'JobTestAnswer', 'QuestionId', 'order' => 'Answers.AnswerId ASC')
    );
  }

  public function beforeDelete()
  {
    JobTestAnswer::model()->deleteAll('QuestionId = :QuestionId', array(':QuestionId' => $this->QuestionId));
    return parent::beforeDelete();
  }

  /**
   * @static
   * @param int $id
   * @return JobTestQuestion
   */
  public static function GetById($id)
  {
    return JobTestQuestion::model()->findByPk($id);
  }
}
