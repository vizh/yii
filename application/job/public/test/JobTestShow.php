<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
AutoLoader::Import('library.texts.*');
 
class JobTestShow extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $jobTest = JobTest::GetById($id, JobTest::LoadFullTest);
    if (empty($jobTest))
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'list'));
    }
    if ($jobTest->VacancyId != null)
    {
      $this->view->VacancyId = $jobTest->Vacancy->VacancyId;
      $this->view->VacancyTitle = $jobTest->Vacancy->Title;
      $this->view->SalaryMin = $jobTest->Vacancy->SalaryMin;
      $this->view->SalaryMax = $jobTest->Vacancy->SalaryMax;
    }
    $this->view->TestId = $jobTest->TestId;
    $this->view->TestTitle = $jobTest->Title;
    $this->view->Date = strftime('%d %B %Y', strtotime($jobTest->CreationTime));
    $this->view->Description = $jobTest->Description;

    $this->view->Info = $this->getTestInfoHtml($jobTest);
    $this->view->Results = $this->getResultsHtml($jobTest);
    $this->view->Submenu = new JobSubmenu('test');
    $this->view->JobTestPartnerBanner = $this->getJobTestPartnerBannerHtml($jobTest);
    echo $this->view;
  }


  /**
   * @param JobTest $jobTest
   * @return View
   */
  private function getTestInfoHtml($jobTest)
  {
    $view = new View();
    $view->SetTemplate('info');

    $questionNumber = sizeof($jobTest->Questions);
    if (! empty($jobTest->QuestionNumber) && $jobTest->QuestionNumber != 0)
    {
      $questionNumber = min($questionNumber, $jobTest->QuestionNumber);
    }
    $view->QuestionNumber = $questionNumber;

    $passTime = $jobTest->PassTime;
    if ($passTime != 0)
    {
      $view->PassTimeHour = floor($jobTest->PassTime / (60*60));
      $view->PassTimeMinute = floor(($jobTest->PassTime % (60*60))/60);
    }

    if ($jobTest->PassResult != null)
    {
      $view->PassResult = $jobTest->PassResult;
      $maxResult = 0;
      foreach ($jobTest->Questions as $question)
      {
        $maxAnswResult = 0;
        foreach ($question->Answers as $answer)
        {
          if ($answer->Result > $maxAnswResult)
          {
            $maxAnswResult = $answer->Result;
          }
        }
        $maxResult += $maxAnswResult;
      }
      $view->MaxResult = $maxResult;
    }

    return $view;
  }

  /**
   * @param JobTest $jobTest
   * @return string
   */
  private function getResultsHtml($jobTest)
  {
    if (empty($this->LoginUser))
    {
      return '';
    }
    $results = JobTestResult::GetByUser($this->LoginUser->UserId, $jobTest->TestId, 0);
    if (! empty($results))
    {
      $view = new View();
      $view->SetTemplate('results');
      $view->Results = $results;
      $view->HavePassArray = ! empty($jobTest->PassArray);

      $lastResult = $results[0];
      $retestTime =  JobTest::GetRetestTime($jobTest->RetestTime);
      $this->view->RetestDeny = strtotime($lastResult->EndTime) + $retestTime > time();
      $this->view->RetestTime = strtotime($lastResult->EndTime) + $retestTime - time();
      return (string)$view;
    }
    else
    {
      return '';
    }
  }
}
