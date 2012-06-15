<?php

/**
 * @property int $AnswerId
 * @property int $QuestionId
 * @property string $Answer
 * @property int $Result
 *
 * @property JobTestQuestion Question
 */
class JobTestAnswer extends CActiveRecord
{
  public static $TableName = 'Mod_JobTestAnswer';

  /**
  * @param string $className
  * @return JobTestAnswer
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
      'Question' => array(self::BELONGS_TO, 'JobTestQuestion', 'AnswerId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return JobTestAnswer
   */
  public static function GetById($id)
  {
    return JobTestAnswer::model()->findByPk($id);
  }
}
