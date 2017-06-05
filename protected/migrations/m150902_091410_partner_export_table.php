<?php

class m150902_091410_partner_export_table extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->createTable('PartnerExport', [
            'Id' => 'serial PRIMARY KEY',
            'EventId' => 'integer NOT NULL',
            'Config' => 'json NOT NULL',
            'UserId' => 'integer NOT NULL',
            'TotalRow' => 'integer',
            'ExportedRow' => 'integer',
            'Success' => 'boolean DEFAULT false NOT NULL',
            'SuccessTime' => 'timestamp',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'FilePath' => 'varchar(255)'
        ]);
        $this->addForeignKey('PartnerExport_EventId_fkey', 'PartnerExport', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('PartnerExport_UserId_fkey', 'PartnerExport', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('PartnerExport_EventId_fkey', 'PartnerExport');
        $this->dropForeignKey('PartnerExport_UserId_fkey', 'PartnerExport');
        $this->dropTable('PartnerExport');
    }
}