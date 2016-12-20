<?php

use api\models\Account;
use application\components\console\BaseConsoleCommand;

class ApiCommand extends BaseConsoleCommand
{
    public function actionQuotas()
    {
        foreach (Account::model()->findAll() as $account) {
            if (count($account->QuotaUsers) > $account->QuotaByUser) {
                $account->Blocked = true;
                $account->BlockedReason = 'Заблокирован в '.date('Y-m-d H:i')." по причине исчерпания квоты в {$account->QuotaByUser} посетителей";
                $account->save(false);
            }
        }
    }
}