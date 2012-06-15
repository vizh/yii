<?php
AutoLoader::Import('job.source.*');
 
class JobStreamDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $jobStream = VacancyStream::GetById($id);
    if ($jobStream != null)
    {
      $jobStream->Status = VacancyStream::StatusDeleted;
      $jobStream->save();
    }


    Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'stream'));
  }
}
