<?php

 
class SettingsBuild extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    StructureManager::GrabStructure();
    echo $this->view;
  }
}
