<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
 
class JobStream extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $this->view->SetTemplate('top', 'job', 'top', '', 'public');
    $page = intval($page);
    $vacancies = VacancyStream::GetByPage(50, $page, VacancyStream::StatusPublish);
    $container = new ViewContainer();
    foreach ($vacancies as $vacancy)
    {
      $view = new View();
      $view->SetTemplate('vacancy');
      $view->VacancyStreamId = $vacancy->VacancyStreamId;
      $view->Title = $vacancy->Title;
      $view->SalaryMin = intval($vacancy->SalaryMin);
      $view->SalaryMax = intval($vacancy->SalaryMax);
      $view->Date = strftime('%d %B %Y', strtotime($vacancy->PublicationDate));
      $view->DescriptionShort = $vacancy->DescriptionShort;

      $container->AddView($view);
    }
    $this->view->Vacancies = $container;

    $this->view->Submenu = new JobSubmenu('stream');
    echo $this->view;
  }

}
