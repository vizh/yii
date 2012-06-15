<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');

class JobShow extends JobGeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $vacancy = Vacancy::GetById($id);
    if (empty($vacancy) ||
        ($vacancy->Status != Vacancy::StatusPublish && !$this->checkAdminAccess()))
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', '', 'top'));
    }
    $this->view->VacancyId = $vacancy->VacancyId;
    $this->view->VacancyTitle = $vacancy->Title;
    $this->view->SalaryMin = intval($vacancy->SalaryMin);
    $this->view->SalaryMax = intval($vacancy->SalaryMax);
    $this->view->Date = strftime('%d %B %Y', strtotime($vacancy->PublicationDate));
    if (! empty($vacancy->Company))
    {
      $this->view->CompanyId = $vacancy->Company->CompanyId;
      $this->view->CompanyName = $vacancy->Company->Name;
    }
    $this->view->Description = $vacancy->Description;

    $this->view->Submenu = new JobSubmenu($vacancy->Type);
    echo $this->view;
  }
}
