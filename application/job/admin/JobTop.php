<?php
AutoLoader::Import('job.source.*');
 
class JobTop extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $vacancies = Vacancy::GetByPage(50, $page, Vacancy::TypeTop, null, null, $account->AccountId(), false);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy');
      $view->VacancyId = $vacancy->VacancyId;
      $view->Title = $vacancy->Title;
      $view->Date = getdate(strtotime($vacancy->PublicationDate));
      $view->Status = $vacancy->Status;

      $container->AddView($view);
    }
    $this->view->Vacancies = $container;

    $this->view->AddUrl = RouteRegistry::GetAdminUrl('job', 'top', 'new');
    echo $this->view;
  }
}
