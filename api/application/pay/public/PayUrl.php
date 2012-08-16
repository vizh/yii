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
    $payerRocId = (int) Registry::GetRequestVar('PayerRocId', null);
    if ($payerRocId == 0)
    {
      throw new ApiException(110);
    }
    $result = new stdClass();
    $result->URL = 'http://pay.'.ROCID_HOST.'/auth/'.$this->Account->EventId.'/'.$payerRocId.'/';
    $this->SendJson($result);
  }
}
