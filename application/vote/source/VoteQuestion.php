<?php
AutoLoader::Import('vote.source.types.*');
AutoLoader::Import('vote.source.validators.*');

/**
 * @property int $QuestionId
 * @property int $VoteId
 * @property string $Question
 * @property string $Description
 * @property int $StepId
 * @property string $Type
 * @property string $TypeParams
 * @property string $Validator
 * @property string $ValidatorParams
 * @property string $Params
 * @property int $Required
 *
 *
 * @property VoteAnswer[] $Answers
 * @property VoteQuestionDepend[] $Depends
 */
class VoteQuestion extends CActiveRecord
{
  public static $TableName = 'Mod_VoteQuestion';

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
      //      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      //      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      //      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      //      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      //      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')

      'Answers' => array(self::HAS_MANY, 'VoteAnswer', 'QuestionId'),
      'Depends' => array(self::HAS_MANY, 'VoteQuestionDepend', 'QuestionId')
    );
  }

  /**
   * @var BaseQuestionType
   */
  private $questionType;
  /**
   * @return BaseQuestionType
   */
  public function QuestionType()
  {
    if (empty($this->questionType))
    {
      $type = $this->Type;
      $this->questionType = new $type($this);
    }
    return $this->questionType;
  }


  /**
   * @param VoteAnswer $answer
   * @param bool $invert
   */
  public function AddDepend($answer, $invert = false)
  {
    $depend = new VoteQuestionDepend();
    $depend->AnswerId = $answer->AnswerId;
    $depend->QuestionId = $this->QuestionId;
    $depend->Invert = $invert ? 1 : 0;
    $depend->save();
  }


  public function GetDependIdList()
  {
    $result = array();
    foreach ($this->Depends as $depend)
    {
      if ($depend->Answer->Question->StepId == $this->StepId)
      {
        $result[] = $depend->Answer->AnswerId;
      }
    }
    return $result;
  }

  /**
   * @param array $data
   * @return bool
   */
  public function CheckDepends($data)
  {
    if (empty($this->Depends))
    {
      return true;
    }
    $flag = true;
    foreach ($this->Depends as $depend)
    {
      if ($depend->Answer->Question->StepId == $this->StepId)
      {
        $flag = false;
      }
      if (isset($data[$depend->Answer->QuestionId]))
      {
        $qData = $data[$depend->Answer->QuestionId];
        if (is_array($qData) && in_array($depend->Answer->AnswerId, $qData))
        {
          return true;
        }
        elseif ($qData == $depend->Answer->AnswerId)
        {
          return true;
        }
      }
    }
    return $flag;
  }

  /**
   * @static
   * @param $voteId
   * @param $stepId
   * @param array|null $answerList
   * @return VoteQuestion[]
   */
  public static function GetByStep($voteId, $stepId, $answerList = null)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.VoteId = :VoteId AND t.StepId = :StepId';
    $criteria->params = array(':VoteId' => $voteId, ':StepId' => $stepId);

//todo: Не понятно, как лучше реализовать. НЕ УДАЛЯТЬ КОД!
//    if ($answerList !== null)
//    {
//      $criteriaDepends = new CDbCriteria();
//      $criteriaDepends->addInCondition('Answer.AnswerId', $answerList);
//      $criteriaDepends->addCondition('Depends.Invert = :Invert');
//      $criteriaDepends->addCondition('Question.StepId = :StepId', 'OR');
//      $criteriaDepends->addCondition('Answer.AnswerId IS NULL', 'OR');
//      $criteriaDepends->params[':Invert'] = 0;
//      $criteriaDepends->params[':StepId'] = $stepId;
//
//      $criteriaDependsSecond = new CDbCriteria();
//      $criteriaDependsSecond->addNotInCondition('Answer.AnswerId', $answerList);
//      $criteriaDependsSecond->addCondition('Depends.Invert = :InvertSecond');
//      $criteriaDependsSecond->params[':InvertSecond'] = 1;
//
//      $criteriaDepends->mergeWith($criteriaDependsSecond, false);
//      $criteria->mergeWith($criteriaDepends);
//    }

    $criteria->order = 't.QuestionId ASC, Answers.AnswerId ASC';

    $model = VoteQuestion::model()->with(array(
      'Answers',
      //'Depends' => array('together' => true, 'select' => false)
      'Depends',
      'Depends.Answer',
      'Depends.Answer.Question'
    ));


    //todo: Фикс для проблемы с несколькими зависимостями, подумать о более приличном решении проблемы
    /** @var $questions VoteQuestion[] */
    $questions = $model->findAll($criteria);
    $result = array();
    $check = array();
    foreach ($questions as $question)
    {
      $flag = true;
      foreach ($question->Depends as $depend)
      {
        if ($depend->Answer->Question->StepId != $stepId)
        {
          if ($depend->Invert == 0 && !in_array($depend->AnswerId, $answerList))
          {
            $flag = false;
          }
          elseif ($depend->Invert == 1 && in_array($depend->AnswerId, $answerList))
          {
            $flag = false;
          }
        }
        elseif (!in_array($depend->Answer->QuestionId, $check))
        {
          $flag = false;
        }
      }
      if ($flag)
      {
        $result[] = $question;
        $check[] = $question->QuestionId;
      }
    }

    return $result;
  }
}