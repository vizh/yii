<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 13.07.11
 * Time: 11:24
 * To change this template use File | Settings | File Templates.
 */
 
class SettingsMaskDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $mask = CoreMask::GetById($id);
    if ($mask != null && $mask->Type != CoreMask::TypeSystem)
    {
      $mask->delete();
    }

    Lib::Redirect(RouteRegistry::GetAdminUrl('settings', '', 'mask'));
  }
}
