<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 19.05.11
 * Time: 18:14
 * To change this template use File | Settings | File Templates.
 */
 
abstract class AjaxAdminCommand extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->UseLayout(false);
  }

  protected function postExecute()
  {
    
  }
}
