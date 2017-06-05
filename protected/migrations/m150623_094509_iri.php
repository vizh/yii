<?php

class m150623_094509_iri extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('IriRole', [
            'Id' => 'serial PRIMARY KEY',
            'Title' => 'varchar(255) NOT NULL',
            'Priority' => 'integer NOT NULL DEFAULT 0'
        ]);

        $this->createTable('IriUser', [
            'Id' => 'serial PRIMARY KEY',
            'UserId' => 'integer NOT NULL',
            'RoleId' => 'integer NOT NULL',
            'Type' => 'varchar(255) NOT NULL',
            'ProfessionalInterestId' => 'integer NULL',
            'JoinTime' => 'timestamp DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'ExitTime' => 'timestamp NULL'
        ]);

        $this->addForeignKey('IriUser_UserId_fkey', 'IriUser', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('IriUser_RoleId_fkey', 'IriUser', 'RoleId', 'IriRole', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('IriUser_ProfessionalInterestId_fkey', 'IriUser', 'ProfessionalInterestId', 'ProfessionalInterest', 'Id', 'RESTRICT', 'RESTRICT');

        $this->insert('IriRole', [
            'Title' => 'Ведущий эксперт ЭС ИРИ'
        ]);
        $this->insert('IriRole', [
            'Title' => 'Эксперт ЭС ИРИ'
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('IriUser_UserId_fkey', 'IriUser');
        $this->dropForeignKey('IriUser_RoleId_fkey', 'IriUser');
        $this->dropForeignKey('IriUser_ProfessionalInterestId_fkey', 'IriUser');
        $this->dropTable('IriRole');
        $this->dropTable('IriUser');
    }
}