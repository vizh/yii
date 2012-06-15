<?php

 
class SettingsGroup extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    echo $this->view;
  }
}
