<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
 
class JobStartup extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $this->view->SetTemplate('top', 'job', 'top', '', 'public');
    $vacancies = Vacancy::GetByPage(50, $page, Vacancy::TypeStartup, Vacancy::StatusPublish, null, null, false);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy', 'job', 'top', '', 'public');
      $view->VacancyId = $vacancy->VacancyId;
      $view->Title = $vacancy->Title;
      $view->SalaryMin = intval($vacancy->SalaryMin);
      $view->SalaryMax = intval($vacancy->SalaryMax);
      $view->Date = strftime('%d %B %Y', strtotime($vacancy->PublicationDate));
      if (! empty($vacancy->Company))
      {
        $view->CompanyId = $vacancy->Company->CompanyId;
        $view->CompanyName = $vacancy->Company->Name;
      }
      $view->DescriptionShort = $vacancy->DescriptionShort;

      $container->AddView($view);
    }
    $this->view->Vacancies = $container;

    $this->view->Submenu = new JobSubmenu(Vacancy::TypeStartup);
    echo $this->view;
  }
}
