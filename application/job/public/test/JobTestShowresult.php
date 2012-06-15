<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
AutoLoader::Import('library.texts.*');
 
class JobTestShowresult extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $testResult = JobTestResult::GetById($id);
    $jobTest = JobTest::GetById($testResult->TestId);
    if (empty($testResult) || empty($this->LoginUser) || empty($jobTest) ||
        $testResult->UserId != $this->LoginUser->UserId)
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'list'));
    }
    if (empty($testResult->EndTime))
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'process', array('id'=>$testResult->TestId)));
    }
    if (! empty($jobTest->VacancyId))
    {
      $this->view->VacancyId = $jobTest->VacancyId;
      $this->view->VacancyTitle = $jobTest->Vacancy->Title;
      $this->view->SalaryMin = $jobTest->Vacancy->SalaryMin;
      $this->view->SalaryMax = $jobTest->Vacancy->SalaryMax;
    }

    $this->view->TestId = $jobTest->TestId;
    $this->view->TestTitle = $jobTest->Title;
    $this->view->Result = $testResult->Result;
    $this->view->Percents = $testResult->Percents;
    $this->view->ResultDescription = $testResult->ResultDescription;

    $retestTime =  JobTest::GetRetestTime($jobTest->RetestTime);
    $this->view->RetestDeny = strtotime($testResult->EndTime) + $retestTime > time();
    $this->view->RetestTime = strtotime($testResult->EndTime) + $retestTime - time();


    $this->view->Submenu = new JobSubmenu('test');
    $this->view->JobTestPartnerBanner = $this->getJobTestPartnerBannerHtml($jobTest);
    echo $this->view;
  }
}
