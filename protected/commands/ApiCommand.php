<?php

use application\components\console\BaseConsoleCommand;
use api\models\AccoutQuotaByUserLog;
use api\models\Account;

class ApiCommand extends BaseConsoleCommand
{
    public function actionQuotas()
    {
        foreach (Account::model()->findAll() as $account) {
            if (AccoutQuotaByUserLog::model()->countByAttributes(['AccountId' => $account->Id]) > $account->QuotaByUser){
                $account->block();
            }
        }
    }

}