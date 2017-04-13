<?php

class m170412_102432_ict_tables extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('IctRole', [
            'Id' => 'serial PRIMARY KEY',
            'Title' => 'varchar(255) NOT NULL',
            'Priority' => 'integer NOT NULL DEFAULT 0'
        ]);

        $this->createTable('IctUser', [
            'Id' => 'serial PRIMARY KEY',
            'UserId' => 'integer NOT NULL',
            'RoleId' => 'integer NOT NULL',
            'Type' => 'varchar(255) NOT NULL',
            'ProfessionalInterestId' => 'integer NULL',
            'JoinTime' => 'timestamp DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'ExitTime' => 'timestamp NULL'
        ]);

        $this->addForeignKey('IctUser_UserId_fkey', 'IctUser', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('IctUser_RoleId_fkey', 'IctUser', 'RoleId', 'IctRole', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('IctUser_ProfessionalInterestId_fkey', 'IctUser', 'ProfessionalInterestId', 'ProfessionalInterest', 'Id', 'RESTRICT', 'RESTRICT');

        $this->insert('IctRole', [
            'Title' => 'Лидер'
        ]);
        $this->insert('IctRole', [
            'Title' => 'Эксперт'
        ]);
        $this->insert('IctRole', [
            'Title' => 'Участник'
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('IctUser_UserId_fkey', 'IctUser');
        $this->dropForeignKey('IctUser_RoleId_fkey', 'IctUser');
        $this->dropForeignKey('IctUser_ProfessionalInterestId_fkey', 'IctUser');
        $this->dropTable('IctRole');
        $this->dropTable('IctUser');
    }
}