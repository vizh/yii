<?php
AutoLoader::Import('job.source.*');

class JobStreamNew extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $account = new JobAccount($this->LoginUser->RocId);

    $vacancy = new VacancyStream();
    $vacancy->AccountId = $account->AccountId();
    $vacancy->Status = VacancyStream::StatusDraft;
    $vacancy->PublicationDate = date('Y-m-d H:i');
    $vacancy->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('job', 'stream', 'edit', array('id' => $vacancy->VacancyStreamId)));
  }
}

