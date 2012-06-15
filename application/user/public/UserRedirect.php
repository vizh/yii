<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 05.09.11
 * Time: 19:48
 * To change this template use File | Settings | File Templates.
 */
 
class UserRedirect extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param int $rocId
   * @return void
   */
  protected function doExecute($rocId = 0)
  {
    Lib::Redirect(RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $rocId)));
  }
}
