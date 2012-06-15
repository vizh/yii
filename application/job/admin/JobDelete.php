<?php
AutoLoader::Import('job.source.*');
 
class JobDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $vacancy = Vacancy::GetById($id);
    if ($vacancy != null)
    {
      $vacancy->Status = Vacancy::StatusDeleted;
      $vacancy->save();
    }

    if ($vacancy->Type == Vacancy::TypeTop)
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'top'));
    }
    else
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'startup'));
    }
  }
}