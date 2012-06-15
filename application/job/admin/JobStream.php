<?php
AutoLoader::Import('job.source.*');
 
class JobStream extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $vacancies = VacancyStream::GetByPage(50, $page, null, null, $account->AccountId(), false);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy');
      $view->VacancyStreamId = $vacancy->VacancyStreamId;
      $view->Title = $vacancy->Title;
      $view->Date = getdate(strtotime($vacancy->PublicationDate));
      $view->Status = $vacancy->Status;

      $container->AddView($view);
    }
    $this->view->Vacancies = $container;

    echo $this->view;
  }
}
