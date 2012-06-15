<?php

 
class EventProgramUserdelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $linkId
   * @return void
   */
  protected function doExecute($linkId = 0)
  {
    $userLink = EventProgramUserLink::GetById($linkId);
    if (empty($userLink))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }
    if (!empty($userLink->Report))
    {
      $userLink->Report->delete();
    }
    $userLink->delete();
    Lib::Redirect(RouteRegistry::GetAdminUrl('event', 'program', 'users', array('id' => $userLink->EventProgramId)));
  }
}
