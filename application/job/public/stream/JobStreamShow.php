<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
 
class JobStreamShow extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $vacancy = VacancyStream::GetById($id);
    if (empty($vacancy)||
        ($vacancy->Status != VacancyStream::StatusPublish && !$this->checkAdminAccess()))
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', '', 'stream'));
    }
    $this->view->VacancyStreamId = $vacancy->VacancyStreamId;
    $this->view->VacancyTitle = $vacancy->Title;
    $this->view->SalaryMin = intval($vacancy->SalaryMin);
    $this->view->SalaryMax = intval($vacancy->SalaryMax);
    $this->view->Date = strftime('%d %B %Y', strtotime($vacancy->PublicationDate));
    $this->view->Description = $vacancy->Description;
    $this->view->Link = $vacancy->Link;

    $this->view->Submenu = new JobSubmenu('stream');
    echo $this->view;
  }
}
