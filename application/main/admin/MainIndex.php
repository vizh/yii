<?php

class MainIndex extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    Lib::Redirect('/admin/news/list/');
  }
}
