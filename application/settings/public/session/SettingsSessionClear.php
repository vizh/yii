<?php

class SettingsSessionClear extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $db = Registry::GetDb();
    $db->createCommand()->delete('YiiSession', 'data = \'\'');
    echo 'session clear';
  }
}
