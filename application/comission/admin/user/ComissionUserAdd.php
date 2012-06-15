<?php
AutoLoader::Import('comission.source.*');
 
class ComissionUserAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $comissionId
   * @return void
   */
  protected function doExecute($comissionId = 0)
  {

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $comissionId = intval($comissionId);
      $rocID = intval(Registry::GetRequestVar('rocID'));
      $role = intval(Registry::GetRequestVar('role'));

      $user = User::GetByRocid($rocID);
      if (empty($user))
      {
        Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
      }

      $cUser = ComissionUser::GetByUserComissionId($user->UserId, $comissionId);
      if (! empty($cUser))
      {
        if ($cUser->ExitTime == null)
        {
          Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'users', array('id' => $comissionId)));
        }
        else
        {
          $cUser->delete();
        }
      }

      $comissionUser = new ComissionUser();
      $comissionUser->ComissionId = $comissionId;
      $comissionUser->UserId = $user->UserId;
      $comissionUser->RoleId = $role;
      $comissionUser->JoinTime = date('Y-m-d H:i:s');
      $comissionUser->save();
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'users', array('id' => $comissionId)));
    }
    else
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
    }
  }
}