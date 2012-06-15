<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
 
class JobTop extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $vacancies = Vacancy::GetByPage(50, $page, Vacancy::TypeTop, Vacancy::StatusPublish, null, null, false);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy');
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
    
    $this->view->Submenu = new JobSubmenu(Vacancy::TypeTop);
    echo $this->view;
  }
}
