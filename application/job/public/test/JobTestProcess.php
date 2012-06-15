<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');

class JobTestProcess extends JobGeneralCommand
{

  /**
   * @var JobTest
   */
  private $jobTest;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    if (! empty($this->LoginUser))
    {
      $id = intval($id);
      $this->initJobTest($id);
      $testResult = JobTestResult::GetByUser($this->LoginUser->UserId, $id);
      $testResult = ! empty($testResult) ? $testResult[0] : null;
      if (empty($testResult) || $testResult->EndTime != null)
      {
        $testResult = $this->createTestResult($id);
      }
      if ($this->jobTest->PassTime != 0 &&
          strtotime($testResult->StartTime) + $this->jobTest->PassTime < time())
      {
        $testResult->FinalizeTestResult();
        Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'showresult', array('id' => $testResult->TestResultId)));
      }
      $questions = $testResult->GetQuestions();
      $answers = $testResult->GetAnswers();
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        $questionId = $questions[sizeof($answers)];
        $answerId = intval(Registry::GetRequestVar('answer'));
        $answer = JobTestAnswer::GetById($answerId);
        if (empty($answer) || $answer->QuestionId != $questionId)
        { 
          Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'process', array('id' => $this->jobTest->TestId)));
        }
        $answers[$questionId] = $answerId;
        $testResult->SetAnswers($answers);
        $testResult->save();
      }
      if (sizeof($answers) == sizeof($questions))
      {
        $testResult->FinalizeTestResult();
        Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'showresult', array('id' => $testResult->TestResultId)));
      }
      $questionId = $questions[sizeof($answers)];
      $question = null;
      foreach ($this->jobTest->Questions as $q)
      {
        if ($q->QuestionId == $questionId)
        {
          $question = $q;
          break;
        }
      }

      $this->view->Answers = $question->Answers;
      $this->view->Question = $question->Question;
      $this->view->QuestionNumber = sizeof($answers)+1;
      $this->view->TotalQuestions = sizeof($questions);
      $this->view->TestId = $this->jobTest->TestId;
      $this->view->TestTitle = $this->jobTest->Title;
    }
    else
    {
      $this->view->SetTemplate('notlogin');
    }
    $this->view->Submenu = new JobSubmenu('test');
    $this->view->JobTestPartnerBanner = $this->getJobTestPartnerBannerHtml($this->jobTest);
    echo $this->view;
  }

  /**
   * @param int $id
   * @return void
   */
  private function initJobTest($id)
  {
    $this->jobTest = JobTest::GetById($id, JobTest::LoadFullTest);
    if (empty($this->jobTest))
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'list'));
    }
  }

  /**
   * @return JobTestResult
   */
  private function createTestResult()
  {
    $testResult = new JobTestResult();
    $testResult->TestId = $this->jobTest->TestId;
    $testResult->UserId = $this->LoginUser->UserId;
    $testResult->StartTime = date('Y-m-d H:i');

    $questions = array();
    foreach ($this->jobTest->Questions as $question)
    {
      $questions[] = $question->QuestionId;
    }
    if ($this->jobTest->QuestionNumber != 0 && sizeof($this->jobTest->Questions) > $this->jobTest->QuestionNumber )
    {
      $keys = array_rand($questions, $this->jobTest->QuestionNumber);
      $questions_temp = array();
      foreach ($keys as $key)
      {
        $questions_temp[] = $questions[$key];
      }
      $questions = $questions_temp;
    }
    $testResult->SetQuestions($questions);
    $testResult->SetAnswers(array());

    $maxResult = 0;
    foreach ($this->jobTest->Questions as $question)
    {
      $maxAnswResult = 0;
      if (in_array($question->QuestionId, $questions))
      {
        foreach ($question->Answers as $answer)
        {
          if ($answer->Result > $maxAnswResult)
          {
            $maxAnswResult = $answer->Result;
          }
        }
        $maxResult += $maxAnswResult;
      }
    }
    $testResult->MaxResult = $maxResult;
    $testResult->save();

    return $testResult;
  }
}