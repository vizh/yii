<?php
AutoLoader::Import('library.rocid.pay.*');
 
class CallbackIndex extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {    
    try
    {
      SystemRouter::Instance()->ParseSystemCallback();
    }
    catch (PayException $e)
    {
      SystemRouter::LogError($e->getMessage(), $e->getCode());
      header('Status: 500');
	    exit();
    }
  }
}

/*****
http://pay.rocid.ru/callback/index?
    DateTime=2011-12-16+08%3a05%3a59&
TransactionID=4188338&
OrderId=5&
 * Amount=1.00&
 * Currency=RUB&
 * SecurityKey=1167a29ab134696b4556200143d90d60&
 * lang=ru&
 * Provider=Card&
 * PaymentAmount=1.00&
 * PaymentCurrency=RUB&
 * CardHolder=VITALIY+NIKITIN&
 * CardNumber=************8527&
 * Country=RU&
 * ECI=5
 * */