<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.02.12
 * Time: 17:12
 * To change this template use File | Settings | File Templates.
 */
class UtilityAgreement extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $view = new View();
    $view->SetTemplate('text', 'core', 'agreement', '', 'public');
    $this->SendJson((object)array('Text' => $view->__toString()));
  }
}
