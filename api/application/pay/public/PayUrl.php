<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 15.03.12
 * Time: 12:17
 * To change this template use File | Settings | File Templates.
 */
class PayUrl extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result = 'http://pay.rocid.ru/' . $this->Account->EventId . '/';
    $this->SendJson($result);
  }
}
