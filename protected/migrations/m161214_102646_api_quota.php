<?php

class m161214_102646_api_quota extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('ApiAccount', 'QuotaByUser', 'integer');
        $this->addColumn('ApiAccount', 'Blocked', 'boolean');
        $this->createTable('ApiAccountQuotaByUserLog', [
            'AccountId' => 'integer not null',
            'UserId' => 'integer not null',
            'Time' => 'timestamp without time zone not null'
        ]);
        $this->addForeignKey('fk__ApiAccountQuotaByUserLog__ApiAccount',
            'ApiAccountQuotaByUserLog', 'AccountId',
            'ApiAccount', 'Id',
            'cascade', 'cascade');
        $this->addForeignKey('fk__ApiAccountQuotaByUserLog__User',
            'ApiAccountQuotaByUserLog', 'UserId',
            'User', 'Id',
            'cascade', 'cascade');
	}

	public function safeDown()
	{
	    $this->dropTable('ApiAccountQuotaByUserLog');
	    $this->dropColumn('ApiAccount', 'Blocked');
        $this->dropColumn('ApiAccount', 'QuotaByUser');
	}
}