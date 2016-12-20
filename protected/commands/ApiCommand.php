<?php

use application\components\console\BaseConsoleCommand;
use api\models\AccoutQuotaByUserLog;
use api\models\Account;

class ApiCommand extends BaseConsoleCommand
{
    public function actionQuotas()
    {
        foreach (Account::model()->findAll() as $account) {
            if (count($account->QuotaUsers) > $account->QuotaByUser){
                $account->Blocked = true;
                $account->BlockedReason = 'Заблокирован в '.date('Y-m-d H:i').' по причине исчерпании квоты в '.$account->QuotaByUser.' посетителей';
                $account->save(false);
            }
        }
    }

}