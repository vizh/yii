<?php
AutoLoader::Import('library.rocid.pay.paypal.*');

class MainPaypalResponse extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    echo $eventId;
    print_r($_REQUEST);
    print_r($_SERVER);


    $paypal = new PayPal('n_1340289183_biz_api1.internetmediaholding.com', '1340289210', 'ASotwUFhF77eR9f46CC9ZDcSDh5XAL4B5T88RqduJwvavxHmvkhlZSvG');
    $paypal->SetSandboxEnable(true);

    $resArray = $paypal->ConfirmPayment($_REQUEST['token'], $_REQUEST['PayerID'], '1.00', 'USD', 'Sale');

    echo '<br><br>RESULT ARRAY:<br><br><pre>';
    print_r($resArray);
    echo '</pre>';
  }
}
