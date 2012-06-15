<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 17.05.12
 * Time: 17:51
 * To change this template use File | Settings | File Templates.
 */
class PartnerLogin extends PartnerCommand
{

  private $error = false;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (Yii::app()->request->getIsPostRequest())
    {
      $login = Registry::GetRequestVar('login');
      $password = Registry::GetRequestVar('password');

      $identity = new PartnerIdentity($login, $password);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->partner->login($identity);
        $backUrl = Registry::GetRequestVar('backUrl', null);
        Lib::Redirect($backUrl == null ? RouteRegistry::GetUrl('partner', '', 'index') : $backUrl);
      }
      else
      {
        $this->error = true;
      }
    }

    $this->view->Error = $this->error;

    echo $this->view;
  }
}
