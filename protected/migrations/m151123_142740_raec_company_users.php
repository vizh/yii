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

        $this->createTable('CompanyLinkCommission', [
            'CompanyId' => 'integer NOT NULL',
            'CommissionId' => 'integer NOT NULL'
        ]);
        $this->addPrimaryKey('CompanyLinkCommission_pkey', 'CompanyLinkCommission', 'CompanyId,CommissionId');
        $this->addForeignKey('CompanyLinkCommission_CompanyId_fkey', 'CompanyLinkCommission', 'CompanyId', 'Company', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('CompanyLinkCommission_CommissionId_fkey', 'CompanyLinkCommission', 'CommissionId', 'Commission', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('CompanyLinkProfessionalInterest', [
            'CompanyId' => 'integer NOT NULL',
            'ProfessionalInterestId' => 'integer NOT NULL',
            'Primary' => 'boolean DEFAULT false'
        ]);
        $this->addPrimaryKey('CompanyLinkProfessionalInterest_pkey', 'CompanyLinkProfessionalInterest', 'CompanyId,ProfessionalInterestId');
        $this->addForeignKey('CompanyLinkProfessionalInterest_CompanyId_fkey', 'CompanyLinkProfessionalInterest', 'CompanyId', 'Company', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('CompanyLinkProfessionalInterest_ProfessionalInterestId_fkey', 'CompanyLinkProfessionalInterest', 'ProfessionalInterestId', 'ProfessionalInterest', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('RaecCompanyUser_CompanyId_fkey', 'RaecCompanyUser');
        $this->dropForeignKey('RaecCompanyUser_UserId_fkey', 'RaecCompanyUser');
        $this->dropForeignKey('RaecCompanyUser_StatusId_fkey', 'RaecCompanyUser');
        $this->dropTable('RaecCompanyUserStatus');
        $this->dropTable('RaecCompanyUser');
        $this->dropForeignKey('CompanyLinkCommission_CompanyId_fkey', 'CompanyLinkCommission');
        $this->dropForeignKey('CompanyLinkCommission_CommissionId_fkey', 'CompanyLinkCommission');
        $this->dropPrimaryKey('CompanyLinkCommission_pkey', 'CompanyLinkCommission');
        $this->dropTable('CompanyLinkCommission');
        $this->dropForeignKey('CompanyLinkProfessionalInterest_CompanyId_fkey', 'CompanyLinkProfessionalInterest');
        $this->dropForeignKey('CompanyLinkProfessionalInterest_ProfessionalInterestId_fkey', 'CompanyLinkProfessionalInterest');
        $this->dropPrimaryKey('CompanyLinkProfessionalInterest_pkey', 'CompanyLinkProfessionalInterest');
        $this->dropTable('CompanyLinkProfessionalInterest');
    }
}