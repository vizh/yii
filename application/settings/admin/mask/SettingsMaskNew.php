<?php

 
class SettingsMaskNew extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $mask = new CoreMask();
    $mask->Type = CoreMask::TypePersonal;
    $mask->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('settings', 'mask', 'edit', array('id' => $mask->MaskId)));
  }
}
