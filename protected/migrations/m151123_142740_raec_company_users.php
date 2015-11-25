<?php

class m151123_142740_raec_company_users extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->createTable('RaecCompanyUserStatus', [
            'Id' => 'serial PRIMARY KEY',
            'Title' => 'varchar(255) NOT NULL'
        ]);
        $this->createTable('RaecCompanyUser', [
            'Id' => 'serial PRIMARY KEY',
            'CompanyId' => 'integer NOT NULL',
            'UserId' => 'integer NOT NULL',
            'StatusId' => 'integer NOT NULL',
            'JoinTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'ExitTime' => 'timestamp',
            'AllowVote' => 'boolean DEFAULT false',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone',
        ]);
        $this->addForeignKey('RaecCompanyUser_CompanyId_fkey', 'RaecCompanyUser', 'CompanyId', 'Company', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('RaecCompanyUser_UserId_fkey', 'RaecCompanyUser', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('RaecCompanyUser_StatusId_fkey', 'RaecCompanyUser', 'StatusId', 'RaecCompanyUserStatus', 'Id', 'RESTRICT', 'RESTRICT');
	}

    public function safeDown()
    {
        $this->dropForeignKey('RaecCompanyUser_CompanyId_fkey', 'RaecCompanyUser');
        $this->dropForeignKey('RaecCompanyUser_UserId_fkey', 'RaecCompanyUser');
        $this->dropForeignKey('RaecCompanyUser_StatusId_fkey', 'RaecCompanyUser');
        $this->dropTable('RaecCompanyUserStatus');
        $this->dropTable('RaecCompanyUser');
    }
}