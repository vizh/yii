<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
 
class JobTestList extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $page = intval($page);
    $tests = JobTest::GetByPage(50, $page, JobTest::StatusPublish);
    $container = new ViewContainer();
    foreach ($tests as $test)
    {
      $view = new View();
      $view->SetTemplate('test');
      $view->TestId = $test->TestId;
      $view->Title = $test->Title;
      $view->Date = strftime('%d %B %Y', strtotime($test->CreationTime));
      $view->DescriptionShort = $test->DescriptionShort;

      $container->AddView($view);
    }
    $this->view->Tests = $container;

    $this->view->Submenu = new JobSubmenu('test');
    echo $this->view;
  }
}
