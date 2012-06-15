<?php

/**
 * @property $StepId
 * @property $VoteId
 * @property $Number
 * @property $Title
 * @property $Description
 */
class VoteStep extends CActiveRecord
{
  public static $TableName = 'Mod_VoteStep';

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
    return 'StepId';
  }

  public function relations()
  {
    return array(
      //      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      //      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      //      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      //      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      //      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
    );
  }

  /**
   * @static
   * @param int $voteId
   * @param int $number
   * @return VoteStep
   */
  public static function GetByNumber($voteId, $number)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.VoteId = :VoteId AND t.Number = :Number';
    $criteria->params = array(':VoteId' => $voteId, ':Number' => $number);
    return VoteStep::model()->find($criteria);
  }


  public function GetCountQuestions($answerList)
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('Depends.QuestionId IS NULL');
    if (!empty($answerList))
    {
      $criteriaDepend = new CDbCriteria();
      $criteriaDepend->addInCondition('Depends.AnswerId', $answerList);
      $criteriaDepend->addCondition('Depends.Invert = 0');

      $criteria->mergeWith($criteriaDepend, false);
    }

    $criteria->addCondition('t.VoteId = :VoteId');
    $criteria->params[':VoteId'] = $this->VoteId;

    $allCount = VoteQuestion::model()->with(array('Depends' => array('tohether' => true, 'select' => false)))->count($criteria);

    $steps = VoteStep::model()->findAll('t.VoteId = :VoteId AND t.Number < :Number', array(':VoteId' => $this->VoteId, ':Number' => $this->Number));
    $stepIdList = array();
    foreach ($steps as $step)
    {
      $stepIdList[] = $step->StepId;
    }

    if (!empty($stepIdList))
    {
      $criteria->addInCondition('t.StepId', $stepIdList);
      $pass = VoteQuestion::model()->with(array('Depends' => array('tohether' => true, 'select' => false)))->count($criteria);
    }
    else
    {
      $pass = 0;
    }

    return array($pass, $allCount);
  }
}