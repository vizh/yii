<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 09.11.11
 * Time: 17:13
 * To change this template use File | Settings | File Templates.
 */
 
class GateChronoError extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    Lib::Redirect('http://bilety.premiaruneta.ru/templates/chrono_payment_failed.html');
  }
}
