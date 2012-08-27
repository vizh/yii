<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/27/12
 * Time: 2:59 PM
 * To change this template use File | Settings | File Templates.
 */
class MainLogin extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $backUrl = Registry::GetRequestVar('backUrl', null);
    if ($this->LoginUser !== null)
    {
      $backUrl = !empty($backUrl) ? $backUrl : '/';
      Lib::Redirect($backUrl);
    }
    echo $this->view;
  }
}
