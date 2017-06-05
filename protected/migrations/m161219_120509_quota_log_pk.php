<?php

class m161219_120509_quota_log_pk extends CDbMigration
{
    public function safeUp()
    {
        // Очищаем накопленные данные по квотам, так как есть дубликаты и не получится создать ключ
        $this->delete('ApiAccountQuotaByUserLog');
        $this->addPrimaryKey('ApiAccountQuotaByUserLog_pkey', 'ApiAccountQuotaByUserLog', ['AccountId', 'UserId']);
        $this->addColumn('ApiAccount', 'BlockedReason', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('ApiAccount', 'BlockedReason');
        $this->dropPrimaryKey('ApiAccountQuotaByUserLog_pkey', 'ApiAccountQuotaByUserLog');
    }
}