<?php
class DefaultCommand extends AbstractCommand
{
  /**
  * Основные действия комманды
  * @return void
  */
  protected function doExecute()
  {
//    if ($_SERVER['REMOTE_ADDR'] == '195.91.129.218')
//    {
//      print_r(RouteRegistry::GetInstance());
//    }
    header('Content-Type: text/html; charset=utf-8');
    $this->Send404AndExit();
  }

}
