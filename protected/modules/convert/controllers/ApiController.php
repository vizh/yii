<?php

class ApiController extends convert\components\controllers\Controller
{

  /**
   * Api аккаунты
   */
  public function actionAccount()
  {
    $accounts = $this->queryAll('SELECT * FROM `Mod_ApiAccount` ORDER BY `AccountId` ASC');
    foreach ($accounts as $account)
    {
      $newAccount = new \api\models\Account();
      $newAccount->Id = $account['AccountId'];
      $newAccount->Key = $account['ApiKey'];
      $newAccount->Secret = $account['SecretKey'];
      $newAccount->EventId = $account['EventId'];
      switch ($account['DataBuilder'])
      {
        case 'PartnerDataBuilder':
          $newAccount->Role = 'partner';
          break;

        case 'MobileAppDataBuilder':
          $newAccount->Role = 'mobile';
          break;

        default:
          $newAccount->Role = 'oldown';
          break;
      }

      $newAccount->save();
      $ipList = unserialize($account['IpList']);
      if (!empty($ipList))
      {
        foreach ($ipList as $ip)
        {
          $newApiIP = new \api\models\Ip();
          $newApiIP->AccountId = $newAccount->Id;
          $newApiIP->Ip = $ip;
          $newApiIP->save();
        }
      }
    }
  }
}
