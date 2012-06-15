<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 18.05.12
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */
class PartnerLogout extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    Yii::app()->partner->logout(false);
    Lib::Redirect(RouteRegistry::GetUrl('partner', '', 'login'));
  }
}
