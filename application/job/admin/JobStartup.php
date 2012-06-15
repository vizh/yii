<?php
AutoLoader::Import('job.source.*');
 
class JobStartup extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $this->view->SetTemplate('top', 'job', 'top', '', 'admin');
    $vacancies = Vacancy::GetByPage(50, $page, Vacancy::TypeStartup, null, null, $account->AccountId(), false);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy', 'job', 'top', '', 'admin');
      $view->VacancyId = $vacancy->VacancyId;
      $view->Title = $vacancy->Title;
      $view->Date = getdate(strtotime($vacancy->PublicationDate));
      $view->Status = $vacancy->Status;

      $container->AddView($view);
    }
    $this->view->Vacancies = $container;

    $this->view->AddUrl = RouteRegistry::GetAdminUrl('job', 'startup', 'new');

    echo $this->view;
  }
}
{

}
