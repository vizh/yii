<?php

use api\models\Account;
use application\components\CDbCriteria;
use application\components\console\BaseConsoleCommand;

class ApiCommand extends BaseConsoleCommand
{
    public function actionQuotas()
    {
        $accounts = Account::model()
            ->with('QuotaUsers')
            ->byRole(Account::ROLE_PARTNER_WOC)
            ->findAll(CDbCriteria::create()
                ->addCondition('"t"."QuotaByUser" > 0'));

        foreach ($accounts as $account) {
            // Немного информации для отладки
            printf("AccountKey: %s, QuotaByUser: %d, QuotaUsed: %d\n",
                $account->Key,
                $account->QuotaByUser,
                count($account->QuotaUsers)
            );

            // Блокируем аккаунт, если превышена квота по пользователям
            if ($account->Blocked !== true && count($account->QuotaUsers) > $account->QuotaByUser) {
                $account->Blocked = true;
                $account->BlockedReason = 'Заблокирован в '.date('Y-m-d H:i')." по причине исчерпания квоты в {$account->QuotaByUser} посетителей";
                $account->save(false);
            }
        }
    }
}