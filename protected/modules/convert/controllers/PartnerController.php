<?php
class PartnerController extends convert\components\controllers\Controller
{
  public function actionAccount()
  {
    $accounts = $this->queryAll('SELECT * FROM `Mod_PartnerAccount` ORDER BY `Mod_PartnerAccount`.`AccountId` ASC');
    foreach ($accounts as $account)
    {
      $newAccount = new \partner\models\Account();
      $newAccount->Id = $account['AccountId'];
      $newAccount->EventId = $account['EventId'];
      $newAccount->Login = $account['Login'];
      $newAccount->Password = $account['Password'];
      $newAccount->NoticeEmail = $account['NoticeEmail'];
      $newAccount->Role = $account['Role'];
      $newAccount->save();
    }
  }
}
