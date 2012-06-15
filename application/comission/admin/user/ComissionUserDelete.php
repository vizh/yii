<?php
AutoLoader::Import('comission.source.*');
 
class ComissionUserDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $comissionUserId
   * @return void
   */
  protected function doExecute($comissionUserId = 0)
  {
    $comissionUserId = intval($comissionUserId);
    $cUser = ComissionUser::GetById($comissionUserId);
    if (!empty($cUser))
    {
      $cUser->ExitTime = date('Y-m-d H:i:s');
      $cUser->save();
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'users', array('id' => $cUser->ComissionId)));
    }
    else
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
    }
  }
}
