<?php


/**
 * @property int $TestResultId
 * @property int $TestId
 * @property int $UserId
 * @property string $Questions
 * @property string $Answers
 * @property int $MaxResult
 * @property int $Result
 * @property int $Percents
 * @property string $ResultDescription
 * @property string $StartTime
 * @property string $EndTime
 */
class JobTestResult extends CActiveRecord
{
  public static $TableName = 'Mod_JobTestResult';

  const ResultSuccess = 'success';
  const ResultFailure = 'failure';

  /**
  * @param string $className
  * @return JobTestResult
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
    return 'TestResultId';
  }

  public function relations()
  {
    return array(
    );
  }

  /**
   * @static
   * @param int $id
   * @return JobTestResult
   */
  public static function GetById($id)
  {
    return JobTestResult::model()->findByPk($id);
  }

  /**
   * @static
   * @param int $userId
   * @param int|null $testId
   * @return JobTestResult[]
   */
  public static function GetByUser($userId, $testId = null, $count = 1)
  {
    $results = JobTestResult::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params[':UserId'] = $userId;

    if (! empty($testId))
    {
      $criteria->condition .= ' AND t.TestId = :TestId';
      $criteria->params[':TestId'] = $testId;
    }

    $criteria->order = 't.StartTime DESC';
    if ($count != 0)
    {
      $criteria->limit = $count;
    }
    return $results->findAll($criteria);
  }


  /**
   * @param array $questions
   * @return void
   */
  public function SetQuestions($questions)
  {
    $this->Questions = base64_encode(serialize($questions));
  }

  /**
   * @return array
   */
  public function GetQuestions()
  {
    return unserialize(base64_decode($this->Questions));
  }

  /**
   * @param array $answers
   * @return void
   */
  public function SetAnswers($answers)
  {
    $this->Answers = base64_encode(serialize($answers));
  }

  /**
   * @return array
   */
  public function GetAnswers()
  {
    return unserialize(base64_decode($this->Answers));
  }

  /**
   * @return void
   */
  public function FinalizeTestResult()
  {
    $jobTest = JobTest::GetById($this->TestId, JobTest::LoadFullTest);
    $answers = $this->GetAnswers();
    $result = 0;
    foreach ($jobTest->Questions as $question)
    {
      foreach ($question->Answers as $answer)
      {
        if (in_array($answer->AnswerId, $answers))
        {
          $result += $answer->Result;
        }
      }
    }
    $this->Result = $result;
    $this->Percents = ceil($result * 100 / $this->MaxResult);

    if (! empty($jobTest->PassResult))
    {
      if ($result >= $jobTest->PassResult)
      {
        $this->ResultDescription = JobTestResult::ResultSuccess;
      }
      else
      {
        $this->ResultDescription = JobTestResult::ResultFailure;
      }
    }
    else
    {
      $passArray = $jobTest->GetPassArray();
      for ($i = 0; $i<sizeof($passArray); $i++)
      {
        $value = $passArray[$i];
        if (($value['start'] <= $result && $result <= $value['end']) || ($i == sizeof($passArray)-1))
        {
          $this->ResultDescription = $value['description'];
          break;
        }
      }
    }
    if ($jobTest->PassTime != 0)
    {
      $this->EndTime = date('Y-m-d H:i', min(time(), strtotime($this->StartTime) + $jobTest->PassTime));
    }
    else
    {
      $this->EndTime = date('Y-m-d H:i');
    }
    $this->save();
  }
}
