<?php
AutoLoader::Import('job.source.*');
 
class JobTestList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $jobTests = JobTest::GetBySingle(50, 1, $account->AccountId());
    $container = new ViewContainer();
    foreach($jobTests as $jobTest)
    {
      $view = new View();
      $view->SetTemplate('jobtest');
      $view->TestId = $jobTest->TestId;
      $view->Title = $jobTest->Title;
      $view->Date = getdate(strtotime($jobTest->CreationTime));
      $view->Status = $jobTest->Status;

      $container->AddView($view);
    }
    $this->view->Tests = $container;
    echo $this->view;
  }
}
