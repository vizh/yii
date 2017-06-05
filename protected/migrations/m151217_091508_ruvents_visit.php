<?php

class m151217_091508_ruvents_visit extends CDbMigration
{
    /**
     *
     */
    public function safeUp()
    {
        $this->createTable('RuventsVisit', [
            'Id' => 'serial PRIMARY KEY',
            'EventId' => 'integer NOT NULL',
            'UserId' => 'integer NOT NULL',
            'MarkId' => 'varchar(255) NOT NULL',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone'
        ]);
        $this->addForeignKey('RuventsVisit_UserId_fkey', 'RuventsVisit', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('RuventsVisit_EventId_fkey', 'RuventsVisit', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropForeignKey('RuventsVisit_UserId_fkey', 'RuventsVisit');
        $this->dropForeignKey('RuventsVisit_EventId_fkey', 'RuventsVisit');
        $this->dropTable('RuventsVisit');
    }
}