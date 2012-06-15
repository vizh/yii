<?php
AutoLoader::Import('job.source.*');
 
class JobStartupNew extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $vacancy = new Vacancy();
    $vacancy->AccountId = $account->AccountId();
    $vacancy->Type = Vacancy::TypeStartup;
    $vacancy->Schedule = Vacancy::ScheduleFull;
    /** Россия */
    $vacancy->CountryId = 3159;
    $vacancy->Status = Vacancy::StatusDraft;
    $vacancy->PublicationDate = date('Y-m-d H:i');
    $vacancy->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'edit', array('id' => $vacancy->VacancyId)));
  }
}