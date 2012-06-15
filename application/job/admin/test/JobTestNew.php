<?php
AutoLoader::Import('job.source.*');
 
class JobTestNew extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($vacancyId = null)
  {
    if (empty($vacancyId))
    {
      $vacancyId = null;
    }
    else
    {
      $vacancyId = intval($vacancyId);
      $vacancy = Vacancy::GetById($vacancyId);
      if (! empty($vacancy))
      {
        $jobTest = $vacancy->JobTest;
        if (! empty($jobTest))
        {
          Lib::Redirect(RouteRegistry::GetAdminUrl('job', 'test', 'edit', array('id' => $jobTest->TestId)));
        }
      }
    }

    $account = new JobAccount($this->LoginUser->RocId);
    
    $jobTest = new JobTest();
    $jobTest->VacancyId = $vacancyId;
    $jobTest->AccountId = $account->AccountId();
    $jobTest->Status = JobTest::StatusDraft;
    $jobTest->CreationTime = date('Y-m-d H:i');
    $jobTest->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('job', 'test', 'edit', array('id' => $jobTest->TestId)));
  }
}
