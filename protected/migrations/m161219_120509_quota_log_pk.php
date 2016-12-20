<?php

class m161219_120509_quota_log_pk extends CDbMigration
{
	public function safeUp()
	{
	    $this->addPrimaryKey('ApiAccountQuotaByUserLog_pkey', 'ApiAccountQuotaByUserLog', ['AccountId', 'UserId']);
	    $this->addColumn('ApiAccount', 'BlockedReason', 'text');
	}

	public function safeDown()
	{
	    $this->dropColumn('ApiAccount', 'BlockedReason');
	    $this->dropForeignKey('ApiAccountQuotaByUserLog_pkey', 'ApiAccountQuotaByUserLog');
	}
}